<?php
/**
 * Helper functions.
 *
 * @since 1.1.11
 * @package Simple_GDPR_Cookie_Compliance
 */
function sgcc_get_options() {

	$settings_values = get_option( 'simple_gdpr_cookie_compliance_options' );

	if ( ! $settings_values ) {
		$settings_values = simple_gdpr_get_setting_defaults();
	}

	return $settings_values;
}
