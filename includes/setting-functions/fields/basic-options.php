<?php
/**
 * Define basic options settings fields of plugin.
 *
 * @link       https://addonify.com/
 * @since      2.0.0
 *
 * @package    simple-gdpr-cookie-compliance
 * @subpackage simple-gdpr-cookie-compliance/includes/setting-functions/fields
 */

if ( ! function_exists( 'simple_gdpr_basic_options' ) ) {
	/**
	 * Basic options.
	 *
	 * @return array
	 */
	function simple_gdpr_basic_options() {
		return array(
			'enable_plugin'      => array(
				'label'       => __( 'Enable cookie notice', 'simple-gdpr-cookie-compliance' ),
				'type'        => 'switch',
				'description' => __( 'Enable this option to activate cookie notice.', 'simple-gdpr-cookie-compliance' ),
			),
			'cookie_expire_time' => array(
				'label'       => __( 'Cookie expiry duration', 'simple-gdpr-cookie-compliance' ),
				'type'        => 'number',
				'unit'        => 'days',
				'min'         => 0,
				'max'         => 365,
				'step'        => 1,
				'description' => __( 'Set how long the notice should be hidden after the user accepts it. Set to 0 to to hide the cookie till the browser is closed.', 'simple-gdpr-cookie-compliance' ),
			),
			'notice_text'        => array(
				'label'       => __( 'Cookie notice message', 'simple-gdpr-cookie-compliance' ),
				'type'        => 'editor',
				'description' => __( 'Actual content of the notice', 'simple-gdpr-cookie-compliance' ),
				'full_width'  => true,
			),
			'show_cookie_icon'   => array(
				'label'       => __( 'Display cookie icon', 'simple-gdpr-cookie-compliance' ),
				'type'        => 'switch',
				'description' => __( 'Displays cookie icon in the cookie notice', 'simple-gdpr-cookie-compliance' ),
			),
		);
	}
}
add_filter( 'simple_gdpr_basic_option_fields', 'simple_gdpr_basic_options' );
