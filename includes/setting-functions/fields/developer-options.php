<?php
/**
 * Define developer options settings fields of plugin.
 *
 * @link       https://addonify.com/
 * @since      2.0.0
 *
 * @package    simple-gdpr-cookie-compliance
 * @subpackage simple-gdpr-cookie-compliance/includes/setting-functions/fields
 */

if ( ! function_exists( 'simple_gdpr_cookie_compliance_developer_options' ) ) {
	/**
	 * General options.
	 *
	 * @return array
	 */
	function simple_gdpr_cookie_compliance_developer_options() {
		return array(
			'custom_css' => array(
				'type'        => 'textarea',
				'label'       => 'Custom CSS',
				'description' => esc_html__( 'Add your custom CSS below if you want to style the notice further.', 'simple-gdpr-cookie-compliance' ),
				'placeholder' => '.app { background-color: #fde047; }',
				'full_width'  => true,
			),
		);
	}
}
add_filter( 'simple_gdpr_cookie_compliance_developer_options_fields', 'simple_gdpr_cookie_compliance_developer_options' );
