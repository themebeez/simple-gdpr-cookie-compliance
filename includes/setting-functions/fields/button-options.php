<?php
/**
 * Define button options settings fields of plugin.
 *
 * @link       https://addonify.com/
 * @since      2.0.0
 *
 * @package    simple-gdpr-cookie-compliance
 * @subpackage simple-gdpr-cookie-compliance/includes/setting-functions/fields
 */

if ( ! function_exists( 'simple_gdpr_button_options' ) ) {
	/**
	 * General options.
	 *
	 * @return array
	 */
	function simple_gdpr_button_options() {
		return array(
			'accept_btn_title' => array(
				'label' => __( 'Accept button label', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'text',
			),
			'show_close_btn' => array(
				'label' => __( 'Display close button', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'switch',
			),
			'notice_compliance_button_bg' => array(
				'label' => __( 'Accept button background color.', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'color',
			),
			'notice_compliance_button_hover_bg_color'     => array(
				'label' => __( 'Accept button background color on hover', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'color',
			),
			'notice_compliance_button_text_color'         => array(
				'label' => __( 'Accept button label color', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'color',
			),
			'notice_compliance_button_hover_text_color'   => array(
				'label' => __( 'Accept button label color on hover', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'color',
			),
			'notice_compliance_button_border_color'       => array(
				'label' => __( 'Accept button border color', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'color',
			),
			'notice_compliance_button_hover_border_color' => array(
				'label' => __( 'Accept button border color on hover', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'color',
			),
			'notice_box_close_btn_bg_color'               => array(
				'label' => __( 'Close button background color', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'color',
			),
			'notice_box_close_btn_bg_hover_color'         => array(
				'label' => __( 'Close button background color on hover', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'color',
			),
			'notice_box_close_btn_text_color'             => array(
				'label' => __( 'Close button label color', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'color',
			),
			'notice_box_close_btn_hover_text_color'       => array(
				'label' => __( 'Close button label color on hover', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'color',
			),
		);
	}
}
add_filter( 'simple_gdpr_button_options', 'simple_gdpr_button_options' );
