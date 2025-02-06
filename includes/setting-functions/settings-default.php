<?php
/**
 * Helper functions.
 *
 * @since 1.1.11
 * @package Simple_GDPR_Cookie_Compliance
 */

if ( ! function_exists( 'simple_gdpr_cookie_compliance_get_setting_defaults' ) ) {

	/**
	 * Get setting defaults.
	 *
	 * @since 1.1.11
	 * @return array
	 */
	function simple_gdpr_cookie_compliance_get_setting_defaults() {
		$settings_default = array(
			'enable_plugin'                               => true,
			'notice_text'                                 => __( "We use cookies to ensure your best experience on our website. If you continue using our website, we'll assume you agree to our <a href='#'>cookie policy</a>", 'simple-gdpr-cookie-compliance' ),
			'accept_btn_title'                            => esc_html__( 'Accept', 'simple-gdpr-cookie-compliance' ),
			'show_close_btn'                              => true,
			'show_cookie_icon'                            => true,
			'cookie_expire_time'                          => 0,
			'enable_bg_overlay'                           => false,
			'style'                                       => 'custom_width',
			'width'                                       => '450',
			'fullwidth_position'                          => 'bottom',
			'customwidth_position'                        => 'bottom_right',
			'custom_width_notice_position_offset'         => array(
				'top_offset'    => '30',
				'right_offset'  => '30',
				'bottom_offset' => '30',
				'left_offset'   => '30',
			),
			'notice_background'                           => '#E4E4E4',
			'notice_text_color'                           => '#222222',
			'notice_link_color'                           => '#222222',
			'notice_link_hover_color'                     => '#00BC7D',
			'notice_cookie_icon_color'                    => '#222222',
			'notice_compliance_button_bg'                 => '#222222',
			'notice_compliance_button_hover_bg_color'     => '#00BC7D',
			'notice_compliance_button_border_color'       => '#222222',
			'notice_compliance_button_hover_border_color' => '#00BC7D',
			'notice_compliance_button_text_color'         => '#ffffff',
			'notice_compliance_button_hover_text_color'   => '#ffffff',
			'notice_box_close_btn_bg_color'               => '#222222',
			'notice_box_close_btn_bg_hover_color'         => '#00BC7D',
			'notice_box_close_btn_text_color'             => '#ffffff',
			'notice_box_close_btn_hover_text_color'       => '#ffffff',
			'notice_bg_overlay_color'                     => '#rgba(0,0,0,0.8)',
			'custom_css'                                  => '',
		);
		return $settings_default;
	}
}
