<?php
/**
 * Functions related to settings page to get and update settings values.
 * This is used to define REST API endpoints used in admin settings page to get and update settings values.
 *
 * @since      1.1.11
 * @package    Simple_GDPR_Cookie_Compliance
 * @subpackage Simple_GDPR_Cookie_Compliance/includes/setting-functions
 * @author     Addonify <contact@addonify.com>
 */

/**
 * Defined functions related to getting and updating settings values.
 *
 * @since      1.1.11
 * @package    Simple_GDPR_Cookie_Compliance
 * @subpackage Simple_GDPR_Cookie_Compliance/includes/setting-functions
 * @author     Addonify <contact@addonify.com>
 */

require_once plugin_dir_path( __DIR__ ) . 'setting-functions/fields/basic-options.php';
require_once plugin_dir_path( __DIR__ ) . 'setting-functions/fields/button-options.php';
require_once plugin_dir_path( __DIR__ ) . 'setting-functions/fields/layout-options.php';
require_once plugin_dir_path( __DIR__ ) . 'setting-functions/fields/developer-options.php';
require_once plugin_dir_path( __DIR__ ) . 'setting-functions/settings-default.php';


if ( ! function_exists( 'simple_gdpr_cookie_compliance_get_fields_values' ) ) {
	/**
	 * Get setting values from database, if not found in data base fetch default values.
	 *
	 * @since 1.1.11
	 *
	 * @return array Option values.
	 */
	function simple_gdpr_cookie_compliance_get_fields_values() {

		$settings_default = simple_gdpr_cookie_compliance_get_setting_defaults();

		$settings_values = array();
		if ( get_option( 'simple_gdpr_cookie_compliance_options' ) ) {
			$saved_settings = get_option( 'simple_gdpr_cookie_compliance_options' );
		} else {
			return $settings_default;
		}

		if ( $settings_default ) {

			$setting_fields = simple_gdpr_cookie_compliance_get_fields(); // get all the available settings fields.
			foreach ( $settings_default as $id => $value ) {

				if ( array_key_exists( $id, $setting_fields ) ) {

					$setting_type = $setting_fields[ $id ]['type'];

					switch ( $setting_type ) {

						case 'switch':
							// special case for enable_bg_overlay because it is saved inside the style array.
							if ( 'enable_bg_overlay' === $id ) {
								$settings_values[ $id ] = (
									isset( $saved_settings['style'][ $id ] ) && '1' === $saved_settings['style'][ $id ] ) ? true :
									( ( isset( $saved_settings['style'][ $id ] ) && '1' !== $saved_settings['style'][ $id ] ) ? false :
									$settings_default[ $id ] );
								break;
							}
							$settings_values[ $id ] = (
								isset( $saved_settings[ $id ] ) && '1' === $saved_settings[ $id ] ) ?
								true :
								( ( isset( $saved_settings[ $id ] ) && '1' !== $saved_settings[ $id ] ) ?
								false :
								$settings_default[ $id ] );
							break;

						case 'radio':
							$settings_values[ $id ] = ( isset( $saved_settings[ $id ]['type'] ) && ! empty( $saved_settings[ $id ]['type'] ) ) ? $saved_settings[ $id ]['type'] : $settings_default[ $id ];
							break;

						case 'number':
							if ( 'width' === $id ) {
								$settings_values[ $id ] = ( isset( $saved_settings['style'][ $id ] ) ) ? $saved_settings['style'][ $id ] : $settings_default[ $id ];
								break;
							}
							$settings_values[ $id ] = ( isset( $saved_settings[ $id ] ) && ! empty( $saved_settings[ $id ] ) ) ? $saved_settings[ $id ] : $settings_default[ $id ];
							break;

						case 'editor':
							$settings_values[ $id ] = ( isset( $saved_settings[ $id ] ) && ! empty( $saved_settings[ $id ] ) ) ? $saved_settings[ $id ] : $settings_default[ $id ];
							break;
						case 'position':
							$settings_values[ $id ]['top_offset'] = ( isset( $saved_settings['style']['top_offset'] ) && ! empty( $saved_settings['style']['top_offset'] ) ) ? $saved_settings['style']['top_offset'] : $settings_default[ $id ]['top_offset'];

							$settings_values[ $id ]['right_offset'] = ( isset( $saved_settings['style']['right_offset'] ) && ! empty( $saved_settings['style']['right_offset'] ) ) ? $saved_settings['style']['right_offset'] : $settings_default[ $id ]['right_offset'];

							$settings_values[ $id ]['bottom_offset'] = ( isset( $saved_settings['style']['bottom_offset'] ) && ! empty( $saved_settings['style']['bottom_offset'] ) ) ? $saved_settings['style']['bottom_offset'] : $settings_default[ $id ]['bottom_offset'];

							$settings_values[ $id ]['left_offset'] = ( isset( $saved_settings['style']['left_offset'] ) && ! empty( $saved_settings['style']['left_offset'] ) ) ? $saved_settings['style']['left_offset'] : $settings_default[ $id ]['left_offset'];
							break;

						case 'select':
							$settings_values[ $id ] = ( isset( $saved_settings['style'][ $id ] ) && ! empty( $saved_settings['style'][ $id ] ) ) ? $saved_settings['style'][ $id ] : $settings_default[ $id ];
							break;
						case 'color':
							// special case for notice_text_color because it is saved inside the color array with notice_text key.
							if ( 'notice_text_color' === $id ) {
								$settings_values[ $id ] = ( isset( $saved_settings['color']['notice_text'] ) && ! empty( $saved_settings['color']['notice_text'] ) ) ? $saved_settings['color']['notice_text'] : $settings_default[ $id ];
								break;
							}
							$settings_values[ $id ] = ( isset( $saved_settings['color'][ $id ] ) && ! empty( $saved_settings['color'][ $id ] ) ) ? $saved_settings['color'][ $id ] : $settings_default[ $id ];
							break;
						case 'textarea':
							$settings_values[ $id ] = ( isset( $saved_settings[ $id ] ) && ! empty( $saved_settings[ $id ] ) ) ? $saved_settings[ $id ] : $settings_default[ $id ];
							break;
						case 'text':
							$settings_values[ $id ] = ( isset( $saved_settings[ $id ] ) && ! empty( $saved_settings[ $id ] ) ) ? $saved_settings[ $id ] : $settings_default[ $id ];
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
 * @since 1.1.11
 * @param mixed $fields Setting fields.
 * @return array
 */
function simple_gdpr_cookie_compliance_add_setting_fields( $fields ) {

	return apply_filters(
		'simple_gdpr_cookie_compliance_add_setting_fields',
		array_merge(
			$fields,
			simple_gdpr_cookie_compliance_basic_options(),
			simple_gdpr_cookie_compliance_layout_options(),
			simple_gdpr_cookie_compliance_button_options(),
			simple_gdpr_cookie_compliance_developer_options(),
		),
	);
}
add_filter( 'simple_gdpr_settings_fields', 'simple_gdpr_cookie_compliance_add_setting_fields' );


if ( ! function_exists( 'simple_gdpr_cookie_compliance_get_fields' ) ) {
	/**
	 * Add setting fields into the global setting fields array.
	 *
	 * @since 1.1.11
	 * @return array
	 */
	function simple_gdpr_cookie_compliance_get_fields() {

		$fields = apply_filters( 'simple_gdpr_settings_fields', array() );
		return $fields;
	}
}


if ( ! function_exists( 'simple_gdpr_cookie_compliance_get_settings_sections_fields' ) ) {
	/**
	 * Define settings sections and respective settings fields.
	 *
	 * @since 1.1.11
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
							'doc_link'      => 'https://docs.addonify.com',
							'fields'        => apply_filters( 'simple_gdpr_cookie_compliance_basic_option_fields', array() ),
						),
						'layout'    => array(
							'section_title' => esc_html__( 'Layout Options', 'simple-gdpr-cookie-compliance' ),
							'fields'        => apply_filters( 'simple_gdpr_cookie_compliance_layout_options_fields', array() ),
						),
						'button'    => array(
							'section_title' => esc_html__( 'Button Options', 'simple-gdpr-cookie-compliance' ),
							'fields'        => apply_filters( 'simple_gdpr_cookie_compliance_button_options_fields', array() ),
						),
						'developer' => array(
							'section_title' => esc_html__( 'Developer', 'simple-gdpr-cookie-compliance' ),
							'fields'        => apply_filters( 'simple_gdpr_cookie_compliance_developer_options_fields', array() ),
						),
					)
				),
			)
		);
	}
}

/**
 * Update settings
 *
 * @since 2.0.0
 *
 * @param string $settings Setting.
 * @return bool true on success, false otherwise.
 */
function simple_gdpr_cookie_compliance_update_settings( $settings = '' ) {
	$settings_default = simple_gdpr_cookie_compliance_get_setting_defaults();
	if (
		is_array( $settings ) &&
		count( $settings ) > 0
	) {
		// fetch all the existing setting fields.
		$setting_fields = simple_gdpr_cookie_compliance_get_fields();

		// initialize empty array.
		$saved_settings = array();
		// Setting values saved in database.
		if ( get_option( 'simple_gdpr_cookie_compliance_options' ) ) {
			$saved_settings = get_option( 'simple_gdpr_cookie_compliance_options' );
		}

		foreach ( $settings as $id => $value ) {
			$sanitized_value = null;

			$setting_type = $setting_fields[ $id ]['type'];

			switch ( $setting_type ) {
				case 'radio':
					$choices                         = $setting_fields[ $id ]['choices'];
					$sanitized_value                 = array_key_exists( $value, $choices ) ? sanitize_text_field( $value ) : $settings_default[ $id ];
					$saved_settings['style']['type'] = $sanitized_value;
					break;
				case 'text':
					$sanitized_value       = sanitize_text_field( $value );
					$saved_settings[ $id ] = $sanitized_value;
					break;
				case 'editor':
					$saved_settings[ $id ] = wp_kses_post( $value );
					break;
				case 'switch':
					// special case for enable_bg_overlay because it is saved inside the style array.
					if ( 'enable_bg_overlay' === $id ) {
						$sanitized_value                = ( true === $value ) ? '1' : '0';
						$saved_settings['style'][ $id ] = $sanitized_value;
						break;
					}
					$sanitized_value       = ( true === $value ) ? '1' : '0';
					$saved_settings[ $id ] = $sanitized_value;
					break;
				case 'number':
					if ( 'width' === $id ) {
						$sanitized_value                  = (int) $value;
						$saved_settings['style']['width'] = $sanitized_value;
						break;
					}
					$sanitized_value       = (int) $value;
					$saved_settings[ $id ] = $sanitized_value;
					break;
				case 'position':
					if ( is_array( $value ) && count( $value ) > 0 ) {
						foreach ( $value as $key => $val ) {
							$sanitized_value                 = (int) ( $val );
							$saved_settings['style'][ $key ] = $sanitized_value;
						}
					}
					break;
				case 'color':
					if ( 'notice_text_color' === $id ) {
						$sanitized_value                        = sanitize_hex_color( $value );
						$saved_settings['color']['notice_text'] = $sanitized_value;
						break;
					}
					$sanitized_value                = sanitize_text_field( $value );
					$saved_settings['color'][ $id ] = $sanitized_value;
					break;
				case 'select':
					$setting_choices                = $setting_fields[ $id ]['choices'];
					$sanitized_value                = ( array_key_exists( $value, $setting_choices ) ) ? sanitize_text_field( $value ) : $settings_default[ $id ];
					$saved_settings['style'][ $id ] = $sanitized_value;
					break;
				default:
					$sanitized_value       = sanitize_text_field( $value );
					$saved_settings[ $id ] = $sanitized_value;
			}
		}
		if ( update_option( 'simple_gdpr_cookie_compliance_options', $saved_settings ) ) {
			return true;
		}
	}
}
