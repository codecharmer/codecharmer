<?php
/**
 * Contact-form inquiry endpoint: POST codecharmer/v1/inquiry.
 *
 * Serves both lead forms: the contact form (formType "project", the default)
 * and the audit request form (formType "audit"). Honeypot + validation +
 * rate limit + wp_mail to the site inbox. The front-end forms fall back to a
 * prefilled mailto: link when this endpoint is unreachable, so they degrade
 * rather than failing.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

namespace CodeCharmer\Core\Rest;

use CodeCharmer\Core\Contracts\Bootable;
use CodeCharmer\Core\Setup\Options;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * REST controller for lead-form inquiries.
 */
final class InquiryController implements Bootable {

	public const ROUTE_NAMESPACE = 'codecharmer/v1';

	/**
	 * Submissions allowed per IP within the rate window.
	 */
	private const RATE_LIMIT = 5;

	/**
	 * Rate window in seconds.
	 */
	private const RATE_WINDOW = 600;

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	public function boot(): void {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * Register the inquiry route.
	 *
	 * @return void
	 */
	public function register_routes(): void {
		register_rest_route(
			self::ROUTE_NAMESPACE,
			'/inquiry',
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'handle' ),
				// Public lead form. The X-WP-Nonce header is sent by the theme
				// and verified by core when present, but a *stale* nonce (page
				// cache) must not lose a real lead, so the gate here is the
				// honeypot + rate limit rather than a hard nonce rejection.
				'permission_callback' => array( $this, 'permission' ),
				'args'                => array(
					'formType'    => array(
						'type'              => 'string',
						'enum'              => array( 'project', 'audit' ),
						'default'           => 'project',
						'sanitize_callback' => 'sanitize_text_field',
					),
					'name'        => array(
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_text_field',
					),
					'company'     => array(
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_text_field',
					),
					'email'       => array(
						'type'              => 'string',
						'required'          => true,
						'sanitize_callback' => 'sanitize_email',
					),
					'projectType' => array(
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_text_field',
					),
					'budget'      => array(
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_text_field',
					),
					'timeline'    => array(
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_text_field',
					),
					'message'     => array(
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_textarea_field',
					),
					'siteUrl'     => array(
						'type'              => 'string',
						'sanitize_callback' => 'esc_url_raw',
					),
					'problem'     => array(
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_text_field',
					),
					'scale'       => array(
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_text_field',
					),
					'timing'      => array(
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_text_field',
					),
					'consent'     => array(
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_text_field',
					),
					'wantsCall'   => array(
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_text_field',
					),
					'sourcePath'  => array(
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_text_field',
					),
					'utm'         => array(
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_text_field',
					),
					'website'     => array(
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_text_field',
					),
				),
			)
		);
	}

	/**
	 * Rate-limit gate: at most RATE_LIMIT accepted submissions per IP per
	 * window. Only checks here; the counter increments when a message is
	 * actually sent, so a visitor fixing validation errors never burns
	 * their budget on failed attempts.
	 *
	 * @return true|\WP_Error
	 */
	public function permission() {
		$key = $this->rate_key();
		if ( '' === $key ) {
			return true;
		}

		if ( (int) get_transient( $key ) >= self::RATE_LIMIT ) {
			return new \WP_Error(
				'cc_rate_limited',
				__( 'Too many messages in a short time. Please try again in a few minutes, or email us directly.', 'codecharmer-core' ),
				array( 'status' => 429 )
			);
		}

		return true;
	}

	/**
	 * The per-IP rate-limit cache key.
	 *
	 * The IP is hashed before it becomes a cache key, so no raw address is
	 * ever stored. Transients ride the object cache, so this stays VIP-safe.
	 *
	 * @return string Empty when no client address is available.
	 */
	private function rate_key(): string {
		// phpcs:ignore WordPressVIPMinimum.Variables.ServerVariables.UserControlledHeaders, WordPressVIPMinimum.Variables.RestrictedVariables.cache_constraints___SERVER__REMOTE_ADDR__, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Rate-limit key only: hashed immediately, never stored raw, never echoed; a REST POST is not page-cached.
		$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? (string) wp_unslash( $_SERVER['REMOTE_ADDR'] ) : '';
		return '' !== $ip ? 'cc_inq_' . md5( $ip ) : '';
	}

	/**
	 * Handle an inquiry submission.
	 *
	 * @param \WP_REST_Request $request The request.
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function handle( \WP_REST_Request $request ) {
		// Honeypot: bots fill the hidden field; humans never see it. Report
		// success so the bot learns nothing.
		if ( '' !== (string) $request->get_param( 'website' ) ) {
			return new \WP_REST_Response( array( 'ok' => true ), 200 );
		}

		$email = (string) $request->get_param( 'email' );
		if ( ! is_email( $email ) ) {
			return new \WP_Error( 'cc_invalid_email', __( 'That email doesn’t look right.', 'codecharmer-core' ), array( 'status' => 400 ) );
		}

		$is_audit = 'audit' === (string) $request->get_param( 'formType' );

		return $is_audit ? $this->handle_audit( $request, $email ) : $this->handle_project( $request, $email );
	}

	/**
	 * Handle a project (contact form) inquiry.
	 *
	 * @param \WP_REST_Request $request The request.
	 * @param string           $email   Validated sender email.
	 * @return \WP_REST_Response|\WP_Error
	 */
	private function handle_project( \WP_REST_Request $request, string $email ) {
		$name    = (string) $request->get_param( 'name' );
		$message = trim( (string) $request->get_param( 'message' ) );

		if ( '' === trim( $name ) ) {
			return new \WP_Error( 'cc_name_required', __( 'Please add your name.', 'codecharmer-core' ), array( 'status' => 400 ) );
		}
		if ( '' === (string) $request->get_param( 'projectType' ) ) {
			return new \WP_Error( 'cc_type_required', __( 'Pick the closest project type.', 'codecharmer-core' ), array( 'status' => 400 ) );
		}
		if ( strlen( $message ) < 10 ) {
			return new \WP_Error( 'cc_message_too_short', __( 'A sentence or two helps us reply well.', 'codecharmer-core' ), array( 'status' => 400 ) );
		}

		$company  = (string) $request->get_param( 'company' );
		$budget   = (string) $request->get_param( 'budget' );
		$timeline = (string) $request->get_param( 'timeline' );

		$lines = array(
			'Name: ' . $name,
			'Company: ' . ( '' !== $company ? $company : '-' ),
			'Email: ' . $email,
			'Project type: ' . (string) $request->get_param( 'projectType' ),
			'Budget: ' . ( '' !== $budget ? $budget : '-' ),
			'Timeline: ' . ( '' !== $timeline ? $timeline : '-' ),
			'',
			$message,
		);

		$subject = sprintf(
			/* translators: %s: sender name */
			__( 'Project inquiry: %s', 'codecharmer-core' ),
			$name
		);

		return $this->send( $request, $subject, $lines, $name, $email );
	}

	/**
	 * Handle an audit request.
	 *
	 * @param \WP_REST_Request $request The request.
	 * @param string           $email   Validated sender email.
	 * @return \WP_REST_Response|\WP_Error
	 */
	private function handle_audit( \WP_REST_Request $request, string $email ) {
		$site_url = (string) $request->get_param( 'siteUrl' );
		$problem  = (string) $request->get_param( 'problem' );

		if ( '' === $site_url ) {
			return new \WP_Error( 'cc_site_required', __( 'We need the site URL to look at.', 'codecharmer-core' ), array( 'status' => 400 ) );
		}
		if ( '' === $problem ) {
			return new \WP_Error( 'cc_problem_required', __( 'Pick the problem costing you the most.', 'codecharmer-core' ), array( 'status' => 400 ) );
		}
		if ( 'yes' !== (string) $request->get_param( 'consent' ) ) {
			return new \WP_Error( 'cc_consent_required', __( 'We can only reply if you agree to be contacted.', 'codecharmer-core' ), array( 'status' => 400 ) );
		}

		$message = trim( (string) $request->get_param( 'message' ) );
		$scale   = (string) $request->get_param( 'scale' );
		$timing  = (string) $request->get_param( 'timing' );
		$budget  = (string) $request->get_param( 'budget' );
		$call    = 'yes' === (string) $request->get_param( 'wantsCall' );

		$lines = array(
			'Email: ' . $email,
			'Site: ' . $site_url,
			'Problem: ' . $problem,
			'Scale: ' . ( '' !== $scale ? $scale : '-' ),
			'Timing: ' . ( '' !== $timing ? $timing : '-' ),
			'Budget band: ' . ( '' !== $budget ? $budget : '-' ),
			'Wants a call: ' . ( $call ? 'yes' : 'no' ),
		);
		if ( '' !== $message ) {
			$lines[] = '';
			$lines[] = $message;
		}

		$subject = sprintf(
			/* translators: %s: the requester's site URL */
			__( 'Audit request: %s', 'codecharmer-core' ),
			preg_replace( '#^https?://#', '', $site_url )
		);

		return $this->send( $request, $subject, $lines, '', $email );
	}

	/**
	 * Append attribution, mail the inquiry, and answer the request.
	 *
	 * @param \WP_REST_Request $request The request (for source/utm params).
	 * @param string           $subject Mail subject.
	 * @param string[]         $lines   Mail body lines.
	 * @param string           $name    Sender name ('' for audit requests).
	 * @param string           $email   Sender email for Reply-To.
	 * @return \WP_REST_Response|\WP_Error
	 */
	private function send( \WP_REST_Request $request, string $subject, array $lines, string $name, string $email ) {
		$source = (string) $request->get_param( 'sourcePath' );
		$utm    = (string) $request->get_param( 'utm' );
		if ( '' !== $source || '' !== $utm ) {
			$lines[] = '';
			$lines[] = '--';
			if ( '' !== $source ) {
				$lines[] = 'Source: ' . $source;
			}
			if ( '' !== $utm ) {
				$lines[] = 'UTM: ' . $utm;
			}
		}

		$reply_to = '' !== $name ? $name . ' <' . $email . '>' : $email;

		// The submission passed every gate: this attempt counts against the
		// rate window, whatever the mail transport does next.
		$rate_key = $this->rate_key();
		if ( '' !== $rate_key ) {
			set_transient( $rate_key, (int) get_transient( $rate_key ) + 1, self::RATE_WINDOW );
		}

		// phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.wp_mail_wp_mail -- Single transactional lead notification, never bulk; the site's one outbound email.
		$sent = wp_mail(
			Options::get( 'email' ),
			$subject,
			implode( "\n", $lines ),
			array( 'Reply-To: ' . $reply_to )
		);

		if ( ! $sent ) {
			return new \WP_Error( 'cc_mail_failed', __( 'Something went wrong sending your message.', 'codecharmer-core' ), array( 'status' => 500 ) );
		}

		return new \WP_REST_Response( array( 'ok' => true ), 200 );
	}
}
