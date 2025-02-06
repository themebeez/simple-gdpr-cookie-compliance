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

if ( ! function_exists( 'simple_gdpr_cookie_compliance_button_options' ) ) {
	/**
	 * Button options.
	 *
	 * @return array
	 */
	function simple_gdpr_cookie_compliance_button_options() {
		return array(
			'accept_btn_title'                            => array(
				'label' => esc_html__( 'Accept button label', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'text',
			),
			'show_close_btn'                              => array(
				'label' => esc_html__( 'Display close button', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'switch',
			),
			'notice_compliance_button_bg'                 => array(
				'label' => esc_html__( 'Accept button background color', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'color',
			),
			'notice_compliance_button_hover_bg_color'     => array(
				'label' => esc_html__( 'Accept button background color on hover', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'color',
			),
			'notice_compliance_button_text_color'         => array(
				'label' => esc_html__( 'Accept button label color', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'color',
			),
			'notice_compliance_button_hover_text_color'   => array(
				'label' => esc_html__( 'Accept button label color on hover', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'color',
			),
			'notice_compliance_button_border_color'       => array(
				'label' => esc_html__( 'Accept button border color', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'color',
			),
			'notice_compliance_button_hover_border_color' => array(
				'label' => esc_html__( 'Accept button border color on hover', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'color',
			),
			'notice_box_close_btn_bg_color'               => array(
				'label'     => esc_html__( 'Close button background color', 'simple-gdpr-cookie-compliance' ),
				'type'      => 'color',
				'dependent' => array(
					'show_close_btn' => true,
				),
			),
			'notice_box_close_btn_bg_hover_color'         => array(
				'label'     => esc_html__( 'Close button background color on hover', 'simple-gdpr-cookie-compliance' ),
				'type'      => 'color',
				'dependent' => array(
					'show_close_btn' => true,
				),
			),
			'notice_box_close_btn_text_color'             => array(
				'label'     => esc_html__( 'Close button label color', 'simple-gdpr-cookie-compliance' ),
				'type'      => 'color',
				'dependent' => array(
					'show_close_btn' => true,
				),
			),
			'notice_box_close_btn_hover_text_color'       => array(
				'label'     => esc_html__( 'Close button label color on hover', 'simple-gdpr-cookie-compliance' ),
				'type'      => 'color',
				'dependent' => array(
					'show_close_btn' => true,
				),
			),
		);
	}
}
add_filter( 'simple_gdpr_cookie_compliance_button_options_fields', 'simple_gdpr_cookie_compliance_button_options' );
