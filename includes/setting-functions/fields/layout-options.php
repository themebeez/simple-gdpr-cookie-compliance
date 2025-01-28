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

if ( ! function_exists( 'simple_gdpr_layout_options' ) ) {
	/**
	 * General options.
	 *
	 * @return array
	 */
	function simple_gdpr_layout_options() {
		return array(
			'style'                               => array(
				'label'       => __( 'Notice layout', 'simple-gdpr-cookie-compliance' ),
				'type'        => 'radio',
				'description' => __( 'Choose how should the notice be look on the website.', 'simple-gdpr-cookie-compliance' ),
				'full_width'  => true,
				'choices'     => array(
					'custom' => __( 'Custom width', 'simple-gdpr-cookie-compliance' ),
					'full'   => __( 'Full width', 'simple-gdpr-cookie-compliance' ),
					'popup'  => __( 'Popup', 'simple-gdpr-cookie-compliance' ),
				),
			),
			'width'                             => array(
				'label'       => __( 'Notice width', 'simple-gdpr-cookie-compliance' ),
				'type'        => 'number',
				'unit'        => 'px',
				'min'         => 300,
				'max'         => 1400,
				'step'        => 5,
				'description' => __( 'Notice width in pixels', 'simple-gdpr-cookie-compliance' ),
				'dependent'   => array( 'popup', 'custom' ),
			),
			'enable_bg_overlay'       => array(
				'label'       => __( 'Enaable background overlay.', 'simple-gdpr-cookie-compliance' ),
				'type'        => 'switch',
				'description' => __( 'Enable or disable background overlay for the cookie notice', 'simple-gdpr-cookie-compliance' ),
				'dependent'   => 'popup',
			),
			'fullwidth_position'              => array(
				'label'       => __( 'Position of the notice', 'simple-gdpr-cookie-compliance' ),
				'type'        => 'select',
				'description' => __( 'Position of the notice', 'simple-gdpr-cookie-compliance' ),
				'choices'     => array(
					'top'    => __( 'Top', 'simple-gdpr-cookie-compliance' ),
					'bottom' => __( 'Bottom', 'simple-gdpr-cookie-compliance' ),
				),
				'dependent'   => 'full_width',
			),
			'notice_bg_overlay_color' => array(
				'label'     => __( 'Overlay background color', 'simple-gdpr-cookie-compliance' ),
				'type'      => 'color',
				'dependent' => array(
					'layout'            => 'popup',
					'enable_bg_overlay' => true,
				),
			),
			'customwidth_position' => array(
				'label'       => __( 'Select where the notice should appear in the website.', 'simple-gdpr-cookie-compliance' ),
				'type'        => 'select',
				'description' => __( 'Position of the notice', 'simple-gdpr-cookie-compliance' ),
				'choices'     => array(
					'top-left'      => __( 'Top left', 'simple-gdpr-cookie-compliance' ),
					'top-right'     => __( 'Top right', 'simple-gdpr-cookie-compliance' ),
					'bottom-left'   => __( 'Bottom left', 'simple-gdpr-cookie-compliance' ),
					'bottom-center' => __( 'Bottom center', 'simple-gdpr-cookie-compliance' ),
					'bottom-right'  => __( 'Bottom right', 'simple-gdpr-cookie-compliance' ),
				),
				'dependent'   => array( 'layout' => 'custom' ),
			),
			'custom_width_notice_position_offset' => array(
				'label'     => __( 'Notice position offset (in pixels)', 'simple-gdpr-cookie-compliance' ),
				'type'      => 'position',
				'choices'   => array(
					'top_offset'    => '30',
					'right_offset'  => '30',
					'left_offset'   => '30',
					'buttom_offset' => '30',
				),
				'dependent' => array( 'layout' => 'custom' ),
			),

			'notice_background'                   => array(
				'label' => __( 'Notice background color', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'color',
			),
			'notice_cookie_icon_color'            => array(
				'label' => __( 'Cookie icon color', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'color',
			),
			'notice_text_clor' => array(
				'label' => __( 'Text color inside the notice', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'color',
			),
			'notice_link_color' => array(
				'label' => __( 'Link color inside the notice', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'color',
			),
			'notice_link_hover_color' => array(
				'label' => __( 'Link hover color inside the notice', 'simple-gdpr-cookie-compliance' ),
				'type'  => 'color',
			),
		);
	}
}
add_filter( 'simple_gdpr_layout_options', 'simple_gdpr_layout_options' );
