<?php
/**
 * Audit request form render: the two-step qualification form.
 *
 * Step 1 is deliberately easy (email, site, biggest problem); step 2 asks for
 * the context that makes the first reply useful. Posts JSON to
 * codecharmer/v1/inquiry with formType=audit (theme JS); with no JS the form
 * degrades to a prefilled mailto via the always-visible address.
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
 * Filter the audit form's problem options.
 *
 * @param string[] $problems Problem labels.
 */
$cc_problems = apply_filters(
	'codecharmer_audit_problems',
	array(
		__( 'Publishing & editorial workflow', 'codecharmer-core' ),
		__( 'Integrations between systems', 'codecharmer-core' ),
		__( 'Commerce operations', 'codecharmer-core' ),
		__( 'Reporting & visibility', 'codecharmer-core' ),
		__( 'Customer-facing workflow', 'codecharmer-core' ),
		__( 'Performance & reliability', 'codecharmer-core' ),
		__( 'Something else', 'codecharmer-core' ),
	)
);

/**
 * Filter the audit form's budget band options.
 *
 * @param string[] $bands Budget band labels.
 */
$cc_bands = apply_filters(
	'codecharmer_audit_budget_bands',
	array( 'US$2.5k – 10k', 'US$10k – 25k', 'US$25k – 75k', 'US$75k+', __( 'Not sure yet', 'codecharmer-core' ) )
);

/**
 * Filter the audit form's timing options.
 *
 * @param string[] $timings Timing labels.
 */
$cc_timings = apply_filters(
	'codecharmer_audit_timings',
	array(
		__( 'As soon as possible', 'codecharmer-core' ),
		__( 'Within the next month', 'codecharmer-core' ),
		__( 'This quarter', 'codecharmer-core' ),
		__( 'Just exploring', 'codecharmer-core' ),
	)
);
?>
<section class="section contact" id="request-audit">
	<div class="container aform__wrap">
		<div class="contact__form reveal">
			<form class="cform aform" data-audit-form data-endpoint="<?php echo esc_url( $cc_endpoint ); ?>" data-nonce="<?php echo esc_attr( $cc_nonce ); ?>" data-email="<?php echo esc_attr( $cc_email ); ?>" novalidate>
				<input type="hidden" name="formType" value="audit" />
				<input type="hidden" name="sourcePath" value="" data-source-path />
				<input type="hidden" name="utm" value="" data-utm />

				<div class="cform__hp" aria-hidden="true">
					<label for="af-website"><?php esc_html_e( 'Website', 'codecharmer-core' ); ?></label>
					<input type="text" id="af-website" name="website" tabindex="-1" autocomplete="off" />
				</div>

				<p class="aform__progress" data-step-label aria-live="polite"><?php esc_html_e( 'Step 1 of 2', 'codecharmer-core' ); ?></p>

				<fieldset class="aform__step" data-step="1">
					<legend class="aform__legend"><?php esc_html_e( 'Where does it hurt?', 'codecharmer-core' ); ?></legend>

					<div class="field">
						<label for="af-email"><?php esc_html_e( 'Work email', 'codecharmer-core' ); ?> <span class="req" aria-hidden="true">*</span></label>
						<input id="af-email" name="email" type="email" autocomplete="email" required aria-describedby="err-af-email" />
						<span class="field__err" id="err-af-email" data-err></span>
					</div>

					<div class="field">
						<label for="af-siteurl"><?php esc_html_e( 'Website URL', 'codecharmer-core' ); ?> <span class="req" aria-hidden="true">*</span></label>
						<input id="af-siteurl" name="siteUrl" type="url" inputmode="url" autocomplete="url" required placeholder="https://" aria-describedby="err-af-siteurl" />
						<span class="field__err" id="err-af-siteurl" data-err></span>
					</div>

					<div class="field">
						<label for="af-problem"><?php esc_html_e( 'Which problem is costing you the most?', 'codecharmer-core' ); ?> <span class="req" aria-hidden="true">*</span></label>
						<div class="select">
							<select id="af-problem" name="problem" required aria-describedby="err-af-problem">
								<option value="" disabled selected><?php esc_html_e( 'Select one…', 'codecharmer-core' ); ?></option>
								<?php foreach ( $cc_problems as $cc_problem ) : ?>
									<option value="<?php echo esc_attr( (string) $cc_problem ); ?>"><?php echo esc_html( (string) $cc_problem ); ?></option>
								<?php endforeach; ?>
							</select>
							<?php Partials::icon( 'arrow', 16, 'select__chev' ); ?>
						</div>
						<span class="field__err" id="err-af-problem" data-err></span>
					</div>

					<div class="cform__foot">
						<button type="button" class="cform__submit" data-step-next>
							<span><?php esc_html_e( 'Continue', 'codecharmer-core' ); ?></span>
						</button>
						<p class="cform__note" role="status" aria-live="polite" data-status-1></p>
					</div>
				</fieldset>

				<fieldset class="aform__step" data-step="2" hidden>
					<legend class="aform__legend"><?php esc_html_e( 'A little context', 'codecharmer-core' ); ?></legend>

					<div class="field">
						<label for="af-message"><?php esc_html_e( 'What happens today?', 'codecharmer-core' ); ?> <span class="opt"><?php esc_html_e( 'optional', 'codecharmer-core' ); ?></span></label>
						<textarea id="af-message" name="message" rows="4" placeholder="<?php esc_attr_e( 'The workflow as it actually runs: who does what, in which tools, and where it slows down.', 'codecharmer-core' ); ?>"></textarea>
					</div>

					<div class="field">
						<label for="af-scale"><?php esc_html_e( 'Roughly how many people, hours, or transactions are affected?', 'codecharmer-core' ); ?> <span class="opt"><?php esc_html_e( 'optional', 'codecharmer-core' ); ?></span></label>
						<input id="af-scale" name="scale" type="text" placeholder="<?php esc_attr_e( 'e.g. 4 editors, ~10 hours a week', 'codecharmer-core' ); ?>" />
					</div>

					<div class="cform__grid">
						<div class="field">
							<label for="af-timing"><?php esc_html_e( 'Timing', 'codecharmer-core' ); ?> <span class="opt"><?php esc_html_e( 'optional', 'codecharmer-core' ); ?></span></label>
							<div class="select">
								<select id="af-timing" name="timing">
									<option value="" disabled selected><?php esc_html_e( 'When would you start?', 'codecharmer-core' ); ?></option>
									<?php foreach ( $cc_timings as $cc_timing ) : ?>
										<option value="<?php echo esc_attr( (string) $cc_timing ); ?>"><?php echo esc_html( (string) $cc_timing ); ?></option>
									<?php endforeach; ?>
								</select>
								<?php Partials::icon( 'arrow', 16, 'select__chev' ); ?>
							</div>
						</div>
						<div class="field">
							<label for="af-budget"><?php esc_html_e( 'Budget band', 'codecharmer-core' ); ?> <span class="opt"><?php esc_html_e( 'optional', 'codecharmer-core' ); ?></span></label>
							<div class="select">
								<select id="af-budget" name="budget">
									<option value="" disabled selected><?php esc_html_e( 'Select a range…', 'codecharmer-core' ); ?></option>
									<?php foreach ( $cc_bands as $cc_band ) : ?>
										<option value="<?php echo esc_attr( (string) $cc_band ); ?>"><?php echo esc_html( (string) $cc_band ); ?></option>
									<?php endforeach; ?>
								</select>
								<?php Partials::icon( 'arrow', 16, 'select__chev' ); ?>
							</div>
						</div>
					</div>

					<div class="field aform__consent">
						<label class="aform__check">
							<input type="checkbox" id="af-consent" name="consent" value="yes" required aria-describedby="err-af-consent" />
							<span><?php esc_html_e( 'You may contact me about this request. Nothing else, no list.', 'codecharmer-core' ); ?></span>
						</label>
						<span class="field__err" id="err-af-consent" data-err></span>
					</div>

					<div class="field">
						<label class="aform__check">
							<input type="checkbox" name="wantsCall" value="yes" />
							<span><?php esc_html_e( 'I’d like to schedule the kickoff call directly.', 'codecharmer-core' ); ?></span>
						</label>
					</div>

					<div class="cform__foot">
						<button type="button" class="btn btn--ghost btn--md aform__back" data-step-back>
							<span class="btn__label"><?php esc_html_e( 'Back', 'codecharmer-core' ); ?></span>
						</button>
						<button type="submit" class="cform__submit" data-submit>
							<span data-submit-label><?php esc_html_e( 'Request the audit', 'codecharmer-core' ); ?></span>
						</button>
						<p class="cform__note" role="status" aria-live="polite" data-status></p>
					</div>
				</fieldset>
			</form>

			<div class="cform-done" data-done hidden tabindex="-1">
				<span class="cform-done__mark" aria-hidden="true"><?php Partials::icon( 'check', 26 ); ?></span>
				<h3 class="cform-done__title"><?php esc_html_e( 'Request received.', 'codecharmer-core' ); ?></h3>
				<p class="cform-done__body" data-done-body>
					<?php
					printf(
						/* translators: %s: response time */
						esc_html__( 'A real person replies %s with the exact scope we’d recommend, or honest questions if the fit isn’t clear yet.', 'codecharmer-core' ),
						esc_html( Options::get( 'response_time' ) )
					);
					?>
				</p>
				<?php
				if ( '' !== $cc_sched ) {
					Partials::button(
						array(
							'label'   => __( 'Schedule the call now', 'codecharmer-core' ),
							'url'     => $cc_sched,
							'variant' => 'primary',
						)
					);
				}
				?>
			</div>

			<p class="contact__direct">
				<?php esc_html_e( 'Prefer email? Reach us directly at', 'codecharmer-core' ); ?>
				<a class="link" href="<?php echo esc_url( 'mailto:' . $cc_email ); ?>"><?php echo esc_html( $cc_email ); ?></a>.
			</p>
		</div>
	</div>
</section>
