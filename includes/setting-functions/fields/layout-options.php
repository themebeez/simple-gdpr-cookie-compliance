<?php
/**
 * Define layout options settings fields of plugin.
 *
 * @link       https://addonify.com/
 * @since      2.0.0
 *
 * @package    simple-gdpr-cookie-compliance
 * @subpackage simple-gdpr-cookie-compliance/includes/setting-functions/fields
 */

if ( ! function_exists( 'simple_gdpr_cookie_compliance_layout_options' ) ) {
	/**
	 * Layout options.
	 *
	 * @return array
	 */
	function simple_gdpr_cookie_compliance_layout_options() {
		return array(
			'style'                               => array(
				'label'       => esc_html__( 'Notice layout', 'simple-gdpr-cookie-compliance' ),
				'type'        => 'radio',
				'description' => esc_html__( 'Select the layout for the cookie notice. The layout options are bar, popup and custom width.', 'simple-gdpr-cookie-compliance' ),
				'full_width'  => true,
				'choices'     => array(
					'custom_width' => esc_html__( 'Custom', 'simple-gdpr-cookie-compliance' ),
					'full_width'   => esc_html__( 'Full width', 'simple-gdpr-cookie-compliance' ),
					'pop_up'       => esc_html__( 'Popup', 'simple-gdpr-cookie-compliance' ),
				),
			),
			'width'                               => array(
				'label'       => esc_html__( 'Notice width', 'simple-gdpr-cookie-compliance' ),
				'type'        => 'number',
				'unit'        => 'px',
				'min'         => 300,
				'max'         => 1400,
				'step'        => 5,
				'description' => esc_html__( 'Notice width in pixels', 'simple-gdpr-cookie-compliance' ),
				'dependent'   => array(
					'style' => array(
						'pop_up',
						'custom_width',
					),
				),
			),
			'enable_bg_overlay'                   => array(
				'label'       => esc_html__( 'Enaable background overlay', 'simple-gdpr-cookie-compliance' ),
				'type'        => 'switch',
				'description' => esc_html__( 'Enable or disable background overlay for the cookie notice', 'simple-gdpr-cookie-compliance' ),
				'dependent'   => array(
					'style' => 'pop_up',
				),
			),
			'fullwidth_position'                  => array(
				'label'       => esc_html__( 'Position of the notice', 'simple-gdpr-cookie-compliance' ),
				'type'        => 'select',
				'description' => esc_html__( 'Select where the notice should appear in the website.', 'simple-gdpr-cookie-compliance' ),
				'choices'     => array(
					'top'    => esc_html__( 'Top', 'simple-gdpr-cookie-compliance' ),
					'bottom' => esc_html__( 'Bottom', 'simple-gdpr-cookie-compliance' ),
				),
				'dependent'   => array(
					'style' => 'full_width',
				),
			),
			'notice_bg_overlay_color'             => array(
				'label'     => esc_html__( 'Overlay background color', 'simple-gdpr-cookie-compliance' ),
				'type'      => 'color',
				'dependent' => array(
					'style'             => 'pop_up',
					'enable_bg_overlay' => true,
				),
			),
			'customwidth_position'                => array(
				'label'       => esc_html__( 'Position of the notice', 'simple-gdpr-cookie-compliance' ),
				'type'        => 'select',
				'description' => esc_html__( 'Select where the notice should appear in the website.', 'simple-gdpr-cookie-compliance' ),
				'choices'     => array(
					'top_left'      => esc_html__( 'Top left', 'simple-gdpr-cookie-compliance' ),
					'top_center'    => esc_html__( 'Top center', 'simple-gdpr-cookie-compliance' ),
					'top_right'     => esc_html__( 'Top right', 'simple-gdpr-cookie-compliance' ),
					'bottom_left'   => esc_html__( 'Bottom left', 'simple-gdpr-cookie-compliance' ),
					'bottom_center' => esc_html__( 'Bottom center', 'simple-gdpr-cookie-compliance' ),
					'bottom_right'  => esc_html__( 'Bottom right', 'simple-gdpr-cookie-compliance' ),
				),
				'dependent'   => array(
					'style' => 'custom_width',
				),
			),
			'custom_width_notice_position_offset' => array(
				'label'     => esc_html__( 'Notice position offset (in pixels)', 'simple-gdpr-cookie-compliance' ),
				'type'      => 'position',
				'choices'   => array(
					'top_offset'    => '30',
					'right_offset'  => '30',
					'bottom_offset' => '30',
					'left_offset'   => '30',
				),
				'dependent' => array( 'style' => 'custom_width' ),
			),

			'notice_background'                   => array(
				'label' => esc_html__( 'Notice background color', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'color',
			),
			'notice_cookie_icon_color'            => array(
				'label' => esc_html__( 'Cookie icon color', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'color',
			),
			'notice_text_color'                   => array(
				'label' => esc_html__( 'Text color inside the notice', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'color',
			),
			'notice_link_color'                   => array(
				'label' => esc_html__( 'Link color inside the notice', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'color',
			),
			'notice_link_hover_color'             => array(
				'label' => esc_html__( 'Link hover color inside the notice', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'color',
			),
		);
	}
}
add_filter( 'simple_gdpr_cookie_compliance_layout_options_fields', 'simple_gdpr_cookie_compliance_layout_options' );
