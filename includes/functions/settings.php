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
			$setting_fields = addonify_quick_view_get_fields();

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

		$settings_values = array();

		$settings_default = addonify_quick_view_setting_defaults();

		if ( $settings_default ) {

			$setting_fields = addonify_quick_view_get_fields(); // get all the avaiable settings fields.

			foreach ( $settings_default as $id => $value ) {

				if ( array_key_exists( $id, $setting_fields ) ) {

					$setting_type = $setting_fields[ $id ]['type'];

					switch ( $setting_type ) {

						case 'switch':
							$settings_values[ $id ] = ( addonify_quick_view_get_option( $id ) === '1' ) ? true : false;
							break;

						case 'checkbox':
							$settings_values[ $id ] = addonify_quick_view_get_option( $id ) ? unserialize( addonify_quick_view_get_option( $id ) ): array(); // phpcs:ignore
							break;

						case 'select':
							if ( isset( $setting_fields[ $id ]['multiple'] ) && $setting_fields[ $id ]['multiple'] ) {

								$setting_value = addonify_quick_view_get_option( $id );
								if ( is_array( $setting_value ) ) {
									$settings_values[ $id ] = $setting_value;
								} else {
									$unserialized_setting_value = json_decode( wp_unslash( $setting_value ), true );
									if ( is_array( $unserialized_setting_value ) ) {
										$settings_values[ $id ] = $unserialized_setting_value;
									} else {
										$settings_values[ $id ] = array();
									}
								}
							} else {
								$settings_values[ $id ] = ( addonify_quick_view_get_option( $id ) === '' ) ? 'Choose value' : addonify_quick_view_get_option( $id );
							}
							break;

						default:
							$settings_values[ $id ] = addonify_quick_view_get_option( $id );
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
function addonify_quick_view_add_setting_fields( $fields ) {

	return apply_filters(
		'addonify_quick_view_add_setting_fields',
		array_merge(
			$fields,
			addonify_quick_view_button_fields(),
			addonify_quick_view_button_style_fields(),
			addonify_quick_view_general_fields(),
			addonify_quick_view_general_styles_fields(),
			addonify_quick_view_modal_box_option_fields(),
			addonify_quick_view_modal_box_ui_option_fields(),
			addonify_quick_view_product_content_option_fields(),
			addonify_quick_view_modal_box_close_button_option_fields(),
			addonify_quick_view_misc_button_inside_modal_box_fields(),
			addonify_quick_view_product_option_fields(),
			addonify_quick_view_product_option_styles_fields(),
		),
	);
}
add_filter( 'addonify_quick_view_settings_fields', 'addonify_quick_view_add_setting_fields' );


if ( ! function_exists( 'addonify_quick_view_get_fields' ) ) {
	/**
	 * Add setting fields into the global setting fields array.
	 *
	 * @since 2.0.0
	 * @return array
	 */
	function addonify_quick_view_get_fields() {

		$fields = apply_filters( 'addonify_quick_view_settings_fields', array() );

		$fields['delete_plugin_data_on_deactivation'] = array(
			'label'       => esc_html__( 'Remove all data on deactivation', 'addonify-quick-view' ),
			'description' => esc_html__( 'If enabled, all of plugin\'s data will be removed without leaving a footprint.', 'addonify-quick-view' ),
			'type'        => 'switch',
			'className'   => '',
			'value'       => addonify_quick_view_get_option( 'delete_plugin_data_on_deactivation' ),
		);

		return $fields;
	}
}

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
				'settings_values' => simple_gdpr_cookie_compliance_get_fields_values(),
				'tabs'            => apply_filters(
					'addonify_quick_view_setting_tabs',
					array(
						'general' => array(
							'title'    => esc_html__( 'General', 'addonify-quick-view' ),
							'icon'     => "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' > <path d='M12,8a4,4,0,1,0,4,4A4,4,0,0,0,12,8Zm0,6a2,2,0,1,1,2-2A2,2,0,0,1,12,14Z' /><path d='M21.294,13.9l-.444-.256a9.1,9.1,0,0,0,0-3.29l.444-.256a3,3,0,1,0-3-5.2l-.445.257A8.977,8.977,0,0,0,15,3.513V3A3,3,0,0,0,9,3v.513A8.977,8.977,0,0,0,6.152,5.159L5.705,4.9a3,3,0,0,0-3,5.2l.444.256a9.1,9.1,0,0,0,0,3.29l-.444.256a3,3,0,1,0,3,5.2l.445-.257A8.977,8.977,0,0,0,9,20.487V21a3,3,0,0,0,6,0v-.513a8.977,8.977,0,0,0,2.848-1.646l.447.258a3,3,0,0,0,3-5.2Zm-2.548-3.776a7.048,7.048,0,0,1,0,3.75,1,1,0,0,0,.464,1.133l1.084.626a1,1,0,0,1-1,1.733l-1.086-.628a1,1,0,0,0-1.215.165,6.984,6.984,0,0,1-3.243,1.875,1,1,0,0,0-.751.969V21a1,1,0,0,1-2,0V19.748a1,1,0,0,0-.751-.969A6.984,6.984,0,0,1,7.006,16.9a1,1,0,0,0-1.215-.165l-1.084.627a1,1,0,1,1-1-1.732l1.084-.626a1,1,0,0,0,.464-1.133,7.048,7.048,0,0,1,0-3.75A1,1,0,0,0,4.79,8.992L3.706,8.366a1,1,0,0,1,1-1.733l1.086.628A1,1,0,0,0,7.006,7.1a6.984,6.984,0,0,1,3.243-1.875A1,1,0,0,0,11,4.252V3a1,1,0,0,1,2,0V4.252a1,1,0,0,0,.751.969A6.984,6.984,0,0,1,16.994,7.1a1,1,0,0,0,1.215.165l1.084-.627a1,1,0,1,1,1,1.732l-1.084.626A1,1,0,0,0,18.746,10.125Z'/></svg>",
							'sections' => apply_filters( 'addonify_quick_view_general_sections', array() ),
						),
						'button'  => array(
							'title'    => esc_html__( 'Button', 'addonify-quick-view' ),
							'icon'     => "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20'><path d='M19,24H5c-2.76,0-5-2.24-5-5V5C0,2.24,2.24,0,5,0h14c2.76,0,5,2.24,5,5v14c0,2.76-2.24,5-5,5ZM5,2c-1.65,0-3,1.35-3,3v14c0,1.65,1.35,3,3,3h14c1.65,0,3-1.35,3-3V5c0-1.65-1.35-3-3-3H5Zm7,18c-4.41,0-8-3.59-8-8S7.59,4,12,4s8,3.59,8,8-3.59,8-8,8Zm0-14c-3.31,0-6,2.69-6,6s2.69,6,6,6,6-2.69,6-6-2.69-6-6-6Zm0,7.5c.83,0,1.5-.67,1.5-1.5s-.67-1.5-1.5-1.5-1.5,.67-1.5,1.5,.67,1.5,1.5,1.5Z'/></svg>",
							'sections' => apply_filters( 'addonify_quick_view_button_sections', array() ),
						),
						'modal'   => array(
							'title'    => esc_html__( 'Modal box', 'addonify-quick-view' ),
							'icon'     => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M10 4v4"/><path d="M2 8h20"/><path d="M6 4v4"/></svg>',
							'sections' => apply_filters( 'addonify_quick_view_modal_sections', array() ),
						),
						'product' => array(
							'title'    => esc_html__( 'Product', 'addonify-quick-view' ),
							'icon'     => '',
							'sections' => apply_filters( 'addonify_quick_view_product_sections', array() ),
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
