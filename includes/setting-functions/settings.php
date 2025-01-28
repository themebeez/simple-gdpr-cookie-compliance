<?php
/**
 * The class to define REST API endpoints used in settings page.
 * This is used to define REST API endpoints used in admin settings page to get and update settings values.
 *
 * @since      1.0.7
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes/setting-functions
 * @author     Addonify <contact@addonify.com>
 */

require_once plugin_dir_path( __DIR__ ) . 'setting-functions/fields/basic-options.php';
require_once plugin_dir_path( __DIR__ ) . 'setting-functions/fields/button-options.php';
require_once plugin_dir_path( __DIR__ ) . 'setting-functions/fields/layout-options.php';
require_once plugin_dir_path( __DIR__ ) . 'setting-functions/fields/developer-options.php';

if ( ! function_exists( 'addonify_quick_view_update_fields_values' ) ) {
	/**
	 * Update settings
	 *
	 * @since 2.0.0
	 *
	 * @param string $settings Setting.
	 * @return bool true on success, false otherwise.
	 */
	function addonify_quick_view_update_fields_values( $settings = '' ) {
		if (
			is_array( $settings ) &&
			count( $settings ) > 0
		) {
			$setting_fields = simple_gdpr_get_fields();

			foreach ( $settings as $id => $value ) {

				$sanitized_value = null;

				$setting_type = $setting_fields[ $id ]['type'];

				switch ( $setting_type ) {

					case 'switch':
						$sanitized_value = ( $value ) ? '1' : '0';
						break;

					case 'checkbox':
						$sanitize_args = array(
							'choices' => $setting_fields[ $id ]['choices'],
							'values'  => $value,
						);

						$sanitized_value = addonify_quick_view_sanitize_multi_choices( $sanitize_args );
						$sanitized_value = serialize( $value ); // phpcs:ignore
						break;

					case 'select':
						$choices     = $setting_fields[ $id ]['choices'];
						$multiselect = isset( $setting_fields[ $id ]['multiple'] ) ? $setting_fields[ $id ]['multiple'] : false;

						if ( $multiselect ) {

							$sanitized_values = array();

							$values_exist = true;
							if ( is_array( $value ) && $value ) {
								foreach ( $value as $val ) {
									if ( ! array_key_exists( $val, $choices ) ) {
										$values_exist = false;
										break;
									} else {
										$sanitized_values[] = sanitize_key( $val );
									}
								}
							}

							if ( ! $values_exist ) {
								$sanitized_values = $defaults[ $id ];
							}

							$sanitized_value = wp_json_encode( $sanitized_values );
						} else { // phpcs:ignore
							if ( array_key_exists( $value, $choices ) ) {
								$sanitized_value = sanitize_text_field( $value );
							} else {
								$sanitized_value = $defaults[ $id ];
							}
						}
						break;

					default:
						$sanitized_value = sanitize_text_field( $value );
						break;
				}

				if ( ! update_option( ADDONIFY_QUICK_VIEW_DB_INITIALS . $id, $sanitized_value ) ) {
					return false;
				}
			}

			return true;
		}
	}
}


if ( ! function_exists( 'simple_gdpr_cookie_compliance_get_fields_values' ) ) {
	/**
	 * Get setting values from database, if not found in data base fetch default values.
	 *
	 * @since 2.0.0
	 *
	 * @return array Option values.
	 */
	function simple_gdpr_cookie_compliance_get_fields_values() {

		$settings_default = array(
			'notice_text'        => __( 'Our website uses cookies to provide you the best experience. However, by continuing to use our website, you agree to our use of cookies. For more information, read our <a href="#">Cookie Policy</a>.', 'simple-gdpr-cookie-compliance' ),
			'accept_btn_title'                            => __( 'Accept', 'simple-gdpr-cookie-compliance' ),
			'show_close_btn'                              => true,
			'show_cookie_icon'                            => true,
			'cookie_expire_time'                          => 0,
			'style'                                       => array(
				'type'              => 'custom_width',
				'enable_bg_overlay' => true,
			),
			'width'                                       => '450',
			'fullwidth_position'                          => 'top',
			'customwidth_position'                        => 'bottom_right',
			'custom_width_notice_position_offset'         => array(
				'top_offset'    => '30',
				'right_offset'  => '30',
				'bottom_offset' => '30',
				'left_offset'   => '30',
			),
			'notice_background'                           => '#fbf01e',
			'notice_text_color'                           => '#222222',
			'notice_link_color'                           => '#222222',
			'notice_link_hover_color'                     => '#4CC500',
			'notice_cookie_icon_color'                    => '#222222',
			'notice_compliance_button_bg'                 => '#222222',
			'notice_compliance_button_hover_bg_color'     => '#4cc500',
			'notice_compliance_button_border_color'       => '#222222',
			'notice_compliance_button_hover_border_color' => '#4cc500',
			'notice_compliance_button_text_color'         => '#ffffff',
			'notice_compliance_button_hover_text_color'   => '#ffffff',
			'notice_box_close_btn_bg_color'               => '#222222',
			'notice_box_close_btn_bg_hover_color'         => '#4cc500',
			'notice_box_close_btn_text_color'             => '#ffffff',
			'notice_box_close_btn_hover_text_color'       => '#ffffff',
			'notice_bg_overlay_color'                     => '#rgba(0,0,0,0.8)',
			'custom_css'                                  => '',

		);

		$settings_values = array();

		$saved_settings = get_option( 'simple_gdpr_cookie_compliance_options' );

		if ( $settings_default ) {

			$setting_fields = simple_gdpr_get_fields(); // get all the avaiable settings fields.

			foreach ( $settings_default as $id => $value ) {

				if ( array_key_exists( $id, $setting_fields ) ) {

					$setting_type = $setting_fields[ $id ]['type'];

					switch ( $setting_type ) {

						case 'switch':
							if ( 'enable_bg_overlay' === $id ) {
								$settings_values[ $id ] = ( '1' === $saved_settings['style'][ $id ] ) ? true : $settings_default[ $id ];
								break;
							}
							$settings_values[ $id ] = ( '1' === $saved_settings[ $id ] ) ? true : ( ( array_key_exists( $id, $saved_settings ) && false === $saved_settings[ $id ] ) ? false : $settings_default[ $id ] );
							break;

						case 'radio':
							$settings_values[ $id ] = ( '' === $saved_settings[ $id ]['type'] ) ? 'custom_width' : $saved_settings[ $id ]['type'];
							break;

						case 'number':
							$settings_values[ $id ] = ( '' === $saved_settings['style']['width'] ) ? $settings_default[ $id ] : $saved_settings['style']['width'];
							break;

						case 'editor':
							$settings_values[ $id ] = ( '' === $saved_settings[ $id ] ) ? $settings_default[ $id ] : $saved_settings[ $id ];
							break;
						case 'position':
							$settings_values[ $id ]['choices']['top_offset'] = ( isset( $saved_settings['style']['top_offset'] ) && ! empty( $saved_settings['style']['top_offset'] ) ) ? $saved_settings['style']['top_offset'] : $settings_default[ $id ]['top_offset'];

							$settings_values[ $id ]['choices']['right_offset'] = ( isset( $saved_settings['style']['right_offset'] ) && ! empty( $saved_settings['style']['right_offset'] ) ) ? $saved_settings['style']['right_offset'] : $settings_default[ $id ]['right_offset'];

							$settings_values[ $id ]['choices']['bottom_offset'] = ( isset( $saved_settings['style']['bottom_offset'] ) && ! empty( $saved_settings['style']['bottom_offset'] ) ) ? $saved_settings['style']['bottom_offset'] : $settings_default[ $id ]['bottom_offset'];

							$settings_values[ $id ]['choices']['left_offset'] = ( isset( $saved_settings['style']['left_offset'] ) && ! empty( $saved_settings['style']['left_offset'] ) ) ? $saved_settings['style']['left_offset'] : $settings_default[ $id ]['left_offset'];
							break;

						case 'select':
							$settings_values[ $id ] = ( '' === $saved_settings['style'][ $id ] ) ? $settings_default[ $id ] : $saved_settings['style'][ $id ];
							break;
						case 'color':
							$settings_values[ $id ] = ( '' === $saved_settings['color'][ $id ] ) ? $settings_default['color'][ $id ] : $saved_settings['color'][ $id ];
							break;
						case 'textarea':
							$settings_values[ $id ] = ( '' === $saved_settings[ $id ] ) ? $settings_default[ $id ] : $saved_settings[ $id ];
							break;

						default:
							$settings_values[ $id ] = $saved_settings[ $id ];
							break;
					}
				}
			}
		}
		return $settings_values;
	}
}

/**
 * Add setting fields into the global setting fields array.
 *
 * @since 2.0.0
 * @param mixed $fields Setting fields.
 * @return array
 */
function simple_gdpr_add_setting_fields( $fields ) {

	return apply_filters(
		'simple_gdpr_add_setting_fields',
		array_merge(
			$fields,
			simple_gdpr_basic_options(),
			simple_gdpr_layout_options(),
			simple_gdpr_button_options(),
			simple_gdpr_developer_options(),
		),
	);
}
add_filter( 'simple_gdpr_settings_fields', 'simple_gdpr_add_setting_fields' );


if ( ! function_exists( 'simple_gdpr_get_fields' ) ) {
	/**
	 * Add setting fields into the global setting fields array.
	 *
	 * @since 2.0.0
	 * @return array
	 */
	function simple_gdpr_get_fields() {

		$fields = apply_filters( 'simple_gdpr_settings_fields', array() );
		return $fields;
	}
}

//error_log( print_r( simple_gdpr_cookie_compliance_get_fields_values(), true ) );
$values = simple_gdpr_cookie_compliance_get_fields_values();
//error_log( print_r( $values, true ) ); // Verify the output

if ( ! function_exists( 'simple_gdpr_cookie_compliance_get_settings_sections_fields' ) ) {
	/**
	 * Define settings sections and respective settings fields.
	 *
	 * @since 2.0.0
	 * @return array
	 */
	function simple_gdpr_cookie_compliance_get_settings_sections_fields() {

		return apply_filters(
			'simple_gdpr_cookie_compliance_get_settings_sections_fields',
			array(
				// fetch all the setting data from database, if not fetch default values.
				'values'   => simple_gdpr_cookie_compliance_get_fields_values(),
				'sections' => apply_filters(
					'sgcc_setting_sections',
					array(
						'basic'     => array(
							'section_title' => esc_html__( 'Basic Options', 'simple-gdpr-cookie-compliance' ),
							"doc_link"      => 'https://docs.addonify.com',
							'feilds'        => apply_filters( 'simple_gdpr_basic_option_feilds', array() ),
						),
						'layout'    => array(
							'title'  => esc_html__( 'Layout Options', 'simple-gdpr-cookie-compliance' ),
							'fields' => apply_filters( 'simple_gdpr_layout_options', array() ),
						),
						'button'    => array(
							'title'  => esc_html__( 'Button Options', 'simple-gdpr-cookie-compliance' ),
							'fields' => apply_filters( 'simple_ghpr_button_options', array() ),
						),
						'developer' => array(
							'section_title' => esc_html__( 'Developer', 'simple-gdpr-cookie-compliance' ),
							'fields'        => apply_filters( 'simple_ghpr_developer_options', array() ),
						),
					)
				),
			)
		);
	}
}


if ( ! function_exists( 'addonify_quick_view_add_setting_tabs_tools' ) ) {
	/**
	 * Add tools setting tab.
	 *
	 * @since 2.0.0
	 *
	 * @param array $setting_tabs Setting tabs.
	 * @return array
	 */
	function addonify_quick_view_add_setting_tabs_tools( $setting_tabs ) {

		$setting_tabs['tools'] = array(
			'title'    => esc_html__( 'Tools', 'addonify-quick-view' ),
			'icon'     => "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20'><path d='M23.854,22.479l-4.545-7.437c.824-.474,1.614-1.027,2.352-1.674,.415-.364,.456-.996,.092-1.411-.366-.416-.996-.455-1.412-.092-.65,.57-1.347,1.055-2.075,1.47l-3.045-4.983c.485-.662,.78-1.47,.78-2.351,0-1.858-1.279-3.411-3-3.858V1c0-.552-.447-1-1-1s-1,.448-1,1v1.142c-1.721,.447-3,2-3,3.858,0,.881,.295,1.689,.78,2.351l-3.045,4.982c-.728-.414-1.425-.899-2.075-1.47-.416-.364-1.046-.324-1.412,.092-.364,.415-.323,1.046,.092,1.412,.737,.647,1.527,1.201,2.352,1.674L.146,22.479c-.288,.472-.14,1.087,.332,1.375,.163,.1,.343,.146,.521,.146,.337,0,.666-.17,.854-.479l4.648-7.606c1.76,.71,3.627,1.077,5.498,1.077s3.738-.367,5.498-1.077l4.648,7.606c.188,.309,.518,.479,.854,.479,.178,0,.357-.047,.521-.146,.472-.288,.62-.903,.332-1.375ZM12,4c1.103,0,2,.897,2,2s-.897,2-2,2-2-.897-2-2,.897-2,2-2ZM7.555,14.191l2.787-4.561c.506,.232,1.064,.37,1.657,.37s1.151-.138,1.657-.37l2.788,4.562c-2.859,1.067-6.03,1.067-8.889,0Z'/></svg>",
			'sections' => array(
				'reset-import-export' => array(
					'title'        => 'Export/Import/Reset Tools',
					'type'         => 'sub_section',
					'sub_sections' => array(
						'export-options' => array(
							'label'       => esc_html__( 'Export settings', 'addonify-quick-view' ),
							'description' => esc_html__( 'Backup all settings that can be imported in future.', 'addonify-quick-view' ),
							'type'        => 'export-option',
							'buttonLabel' => esc_html__( 'Export', 'addonify-quick-view' ),
						),
						'import-options' => array(
							'type'        => 'import-option',
							'label'       => esc_html__( 'Import settings', 'addonify-quick-view' ),
							'caption'     => esc_html__( 'Drop a file here or click here to upload.', 'addonify-quick-view' ),
							'note'        => esc_html__( 'Only .json file is permitted.', 'addonify-quick-view' ),
							'description' => esc_html__( 'Drag or upload the .json file that you had exported.', 'addonify-quick-view' ),
							'width'       => 'full',
						),
						'reset-options'  => array(
							'type'        => 'reset-option',
							'label'       => esc_html__( 'Reset settings', 'addonify-quick-view' ),
							'description' => esc_html__( 'All the settings will be set to default.', 'addonify-quick-view' ),
							'task'        => array(
								'type'        => 'POST',
								'endpoint'    => 'reset_options',
								'opperation'  => 'reset',
								'buttonLabel' => esc_html__( 'Reset', 'addonify-quick-view' ),
								'buttonIcon'  => '',
								'buttonClass' => 'danger',
								'confirm'     => array(
									'required'        => true,
									'confirmBtnLabel' => esc_html__( 'Yes', 'addonify-quick-view' ),
									'cancelBtnLabel'  => esc_html__( 'No, cancel', 'addonify-quick-view' ),
									'content'         => esc_html__( 'Are you sure you would like to reset all settings?', 'addonify-quick-view' ),
									'size'            => '200px',
								),
							),
						),
						'delete_plugin_data_on_deactivation' => array(
							'label'       => esc_html__( 'Delete plugin data on plugin deactivation', 'addonify-quick-view' ),
							'description' => apply_filters(
								'addonify_quick_view_delete_plugin_data_on_deactivation_option_desc',
								esc_html__( 'Enable this option to remove all data related to the plugin on plugin uninstallation.', 'addonify-quick-view' )
							),
							'type'        => 'switch',
							'className'   => '',
							'badge'       => 'Required',
							'value'       => addonify_quick_view_get_option( 'delete_plugin_data_on_deactivation' ),
						),
					),
				),
			),
		);

		return $setting_tabs;
	}

	add_filter( 'addonify_quick_view_setting_tabs', 'addonify_quick_view_add_setting_tabs_tools', 20 );
}
