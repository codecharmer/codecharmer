<?php
/**
 * Contact-form inquiry endpoint: POST codecharmer/v1/inquiry.
 *
 * Honeypot + validation + wp_mail to the site inbox. The front-end form falls
 * back to a prefilled mailto: link when this endpoint is unreachable, so the
 * form degrades rather than failing.
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
 * REST controller for contact-form inquiries.
 */
final class InquiryController implements Bootable {

	public const ROUTE_NAMESPACE = 'codecharmer/v1';

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
				'permission_callback' => '__return_true', // Public lead form; abuse is mitigated below.
				'args'                => array(
					'name'        => array(
						'type'              => 'string',
						'required'          => true,
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
						'required'          => true,
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
						'required'          => true,
						'sanitize_callback' => 'sanitize_textarea_field',
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

		$email   = (string) $request->get_param( 'email' );
		$message = trim( (string) $request->get_param( 'message' ) );

		if ( ! is_email( $email ) ) {
			return new \WP_Error( 'cc_invalid_email', __( 'That email doesn’t look right.', 'codecharmer-core' ), array( 'status' => 400 ) );
		}
		if ( strlen( $message ) < 10 ) {
			return new \WP_Error( 'cc_message_too_short', __( 'A sentence or two helps us reply well.', 'codecharmer-core' ), array( 'status' => 400 ) );
		}

		$name    = (string) $request->get_param( 'name' );
		$to      = Options::get( 'email' );
		$subject = sprintf(
			/* translators: %s: sender name */
			__( 'Project inquiry: %s', 'codecharmer-core' ),
			$name
		);

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

		// phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.wp_mail_wp_mail -- Single transactional lead notification, never bulk; the site's one outbound email.
		$sent = wp_mail(
			$to,
			$subject,
			implode( "\n", $lines ),
			array( 'Reply-To: ' . $name . ' <' . $email . '>' )
		);

		if ( ! $sent ) {
			return new \WP_Error( 'cc_mail_failed', __( 'Something went wrong sending your message.', 'codecharmer-core' ), array( 'status' => 500 ) );
		}

		return new \WP_REST_Response( array( 'ok' => true ), 200 );
	}
}
