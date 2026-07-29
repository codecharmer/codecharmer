<?php
/**
 * Contact section render: form + aside cards.
 *
 * The form posts JSON to codecharmer/v1/inquiry (theme JS); with no JS it
 * degrades to the visitor emailing directly via the always-visible address.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

use CodeCharmer\Core\Render\Partials;
use CodeCharmer\Core\Rest\InquiryController;
use CodeCharmer\Core\Setup\Options;

$cc_email    = Options::get( 'email' );
$cc_endpoint = rest_url( InquiryController::ROUTE_NAMESPACE . '/inquiry' );
$cc_nonce    = wp_create_nonce( 'wp_rest' );
$cc_sched    = Options::get( 'scheduling_url' );

/**
 * Filter the contact form's project type options.
 *
 * @param string[] $types Project type labels.
 */
$cc_types = apply_filters(
	'codecharmer_project_types',
	array(
		__( 'AI strategy & architecture', 'codecharmer-core' ),
		__( 'WordPress engineering', 'codecharmer-core' ),
		__( 'Custom software', 'codecharmer-core' ),
		__( 'AI automation', 'codecharmer-core' ),
		__( 'Not sure yet', 'codecharmer-core' ),
	)
);

/**
 * Filter the contact form's budget range options.
 *
 * @param string[] $ranges Budget range labels.
 */
$cc_budgets = apply_filters(
	'codecharmer_budget_ranges',
	array( 'Under $10k', '$10k – $25k', '$25k – $50k', '$50k+', __( 'Not sure yet', 'codecharmer-core' ) )
);

/**
 * Filter the contact form's timeline options.
 *
 * @param string[] $timelines Timeline labels.
 */
$cc_timelines = apply_filters(
	'codecharmer_timelines',
	array(
		__( 'As soon as possible', 'codecharmer-core' ),
		__( 'Within 1–3 months', 'codecharmer-core' ),
		__( '3–6 months', 'codecharmer-core' ),
		__( 'Just exploring', 'codecharmer-core' ),
	)
);

$cc_steps = array(
	array(
		'title' => __( 'We read it properly', 'codecharmer-core' ),
		'body'  => sprintf(
			/* translators: %s: response time, e.g. "within one business day" */
			__( 'A real person replies %s — not an autoresponder.', 'codecharmer-core' ),
			Options::get( 'response_time' )
		),
	),
	array(
		'title' => __( 'A short conversation', 'codecharmer-core' ),
		'body'  => __( 'Usually 30 minutes to understand the problem and whether we’re the right fit.', 'codecharmer-core' ),
	),
	array(
		'title' => __( 'A clear proposal', 'codecharmer-core' ),
		'body'  => __( 'Scope, approach, and price — enough to make a confident decision.', 'codecharmer-core' ),
	),
);
?>
<section class="section contact">
	<div class="container contact__grid">
		<div class="contact__form reveal">
			<form class="cform" data-contact-form data-endpoint="<?php echo esc_url( $cc_endpoint ); ?>" data-nonce="<?php echo esc_attr( $cc_nonce ); ?>" data-email="<?php echo esc_attr( $cc_email ); ?>" novalidate>
				<div class="cform__hp" aria-hidden="true">
					<label for="cf-website"><?php esc_html_e( 'Website', 'codecharmer-core' ); ?></label>
					<input type="text" id="cf-website" name="website" tabindex="-1" autocomplete="off" />
				</div>

				<div class="cform__grid">
					<div class="field">
						<label for="cf-name"><?php esc_html_e( 'Name', 'codecharmer-core' ); ?> <span class="req" aria-hidden="true">*</span></label>
						<input id="cf-name" name="name" type="text" autocomplete="name" required aria-describedby="err-name" />
						<span class="field__err" id="err-name" data-err></span>
					</div>
					<div class="field">
						<label for="cf-company"><?php esc_html_e( 'Company', 'codecharmer-core' ); ?> <span class="opt"><?php esc_html_e( 'optional', 'codecharmer-core' ); ?></span></label>
						<input id="cf-company" name="company" type="text" autocomplete="organization" />
					</div>
				</div>

				<div class="field">
					<label for="cf-email"><?php esc_html_e( 'Email', 'codecharmer-core' ); ?> <span class="req" aria-hidden="true">*</span></label>
					<input id="cf-email" name="email" type="email" autocomplete="email" required aria-describedby="err-email" />
					<span class="field__err" id="err-email" data-err></span>
				</div>

				<div class="cform__grid">
					<div class="field">
						<label for="cf-type"><?php esc_html_e( 'Project type', 'codecharmer-core' ); ?> <span class="req" aria-hidden="true">*</span></label>
						<div class="select">
							<select id="cf-type" name="projectType" required aria-describedby="err-type">
								<option value="" disabled selected><?php esc_html_e( 'Select one…', 'codecharmer-core' ); ?></option>
								<?php foreach ( $cc_types as $cc_type ) : ?>
									<option value="<?php echo esc_attr( (string) $cc_type ); ?>"><?php echo esc_html( (string) $cc_type ); ?></option>
								<?php endforeach; ?>
							</select>
							<?php Partials::icon( 'arrow', 16, 'select__chev' ); ?>
						</div>
						<span class="field__err" id="err-type" data-err></span>
					</div>
					<div class="field">
						<label for="cf-budget"><?php esc_html_e( 'Budget', 'codecharmer-core' ); ?> <span class="opt"><?php esc_html_e( 'optional', 'codecharmer-core' ); ?></span></label>
						<div class="select">
							<select id="cf-budget" name="budget">
								<option value="" disabled selected><?php esc_html_e( 'Select a range…', 'codecharmer-core' ); ?></option>
								<?php foreach ( $cc_budgets as $cc_budget ) : ?>
									<option value="<?php echo esc_attr( (string) $cc_budget ); ?>"><?php echo esc_html( (string) $cc_budget ); ?></option>
								<?php endforeach; ?>
							</select>
							<?php Partials::icon( 'arrow', 16, 'select__chev' ); ?>
						</div>
					</div>
				</div>

				<div class="field">
					<label for="cf-timeline"><?php esc_html_e( 'Timeline', 'codecharmer-core' ); ?> <span class="opt"><?php esc_html_e( 'optional', 'codecharmer-core' ); ?></span></label>
					<div class="select">
						<select id="cf-timeline" name="timeline">
							<option value="" disabled selected><?php esc_html_e( 'When do you want to start?', 'codecharmer-core' ); ?></option>
							<?php foreach ( $cc_timelines as $cc_timeline ) : ?>
								<option value="<?php echo esc_attr( (string) $cc_timeline ); ?>"><?php echo esc_html( (string) $cc_timeline ); ?></option>
							<?php endforeach; ?>
						</select>
						<?php Partials::icon( 'arrow', 16, 'select__chev' ); ?>
					</div>
				</div>

				<div class="field">
					<label for="cf-message"><?php esc_html_e( 'What are you trying to build?', 'codecharmer-core' ); ?> <span class="req" aria-hidden="true">*</span></label>
					<textarea id="cf-message" name="message" rows="5" required aria-describedby="err-message" placeholder="<?php esc_attr_e( 'A sentence or two about the problem, the goal, and anything we should know.', 'codecharmer-core' ); ?>"></textarea>
					<span class="field__err" id="err-message" data-err></span>
				</div>

				<div class="cform__foot">
					<button type="submit" class="cform__submit" data-submit>
						<span data-submit-label><?php esc_html_e( 'Send inquiry', 'codecharmer-core' ); ?></span>
					</button>
					<p class="cform__note" role="status" aria-live="polite" data-status></p>
				</div>
			</form>

			<div class="cform-done" data-done hidden tabindex="-1">
				<span class="cform-done__mark" aria-hidden="true"><?php Partials::icon( 'check', 26 ); ?></span>
				<h3 class="cform-done__title"><?php esc_html_e( 'Thanks — that’s everything we need.', 'codecharmer-core' ); ?></h3>
				<p class="cform-done__body" data-done-body>
					<?php
					printf(
						/* translators: %s: response time */
						esc_html__( 'We’ll get back to you %s. In the meantime, feel free to reply to the email with anything you forgot.', 'codecharmer-core' ),
						esc_html( Options::get( 'response_time' ) )
					);
					?>
				</p>
			</div>
		</div>

		<aside class="contact__aside reveal">
			<div class="aside-card">
				<h2 class="aside-card__title"><?php esc_html_e( 'What happens next', 'codecharmer-core' ); ?></h2>
				<ol role="list" class="steps">
					<?php foreach ( $cc_steps as $cc_i => $cc_step ) : ?>
						<li class="step">
							<span class="step__n"><?php echo esc_html( (string) ( $cc_i + 1 ) ); ?></span>
							<div>
								<p class="step__t"><?php echo esc_html( $cc_step['title'] ); ?></p>
								<p class="step__b"><?php echo esc_html( $cc_step['body'] ); ?></p>
							</div>
						</li>
					<?php endforeach; ?>
				</ol>
			</div>

			<div class="aside-card aside-card--talk">
				<span class="aside-card__icon"><?php Partials::icon( 'calendar', 22 ); ?></span>
				<h2 class="aside-card__title"><?php esc_html_e( 'Prefer to talk?', 'codecharmer-core' ); ?></h2>
				<p class="aside-card__body"><?php esc_html_e( 'Skip the form and book a time that suits you.', 'codecharmer-core' ); ?></p>
				<?php
				if ( '' !== $cc_sched ) {
					Partials::button(
						array(
							'label'   => __( 'Book a time', 'codecharmer-core' ),
							'url'     => $cc_sched,
							'variant' => 'secondary',
						)
					);
				} else {
					Partials::button(
						array(
							'label'   => __( 'Email to book a call', 'codecharmer-core' ),
							'url'     => 'mailto:' . $cc_email . '?subject=' . rawurlencode( __( 'Booking a call', 'codecharmer-core' ) ),
							'variant' => 'secondary',
						)
					);
				}
				?>
			</div>

			<p class="contact__direct">
				<?php esc_html_e( 'Or reach us directly at', 'codecharmer-core' ); ?>
				<a class="link" href="<?php echo esc_url( 'mailto:' . $cc_email ); ?>"><?php echo esc_html( $cc_email ); ?></a>.
			</p>
		</aside>
	</div>
</section>
