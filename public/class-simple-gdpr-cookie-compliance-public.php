<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @package    Simple_GDPR_Cookie_Compliance
 * @subpackage Simple_GDPR_Cookie_Compliance/public
 * @author     themebeez <themebeez@gmail.com>
 */

/**
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Simple_GDPR_Cookie_Compliance
 * @subpackage Simple_GDPR_Cookie_Compliance/public
 * @author     themebeez <themebeez@gmail.com>
 */
class Simple_GDPR_Cookie_Compliance_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'assets/dist/public.min.css',
			array(),
			$this->version,
			'all'
		);
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_register_script(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'assets/dist/public.min.js',
			array(),
			$this->version,
			true
		);

		$simple_gdpr_cookie_compliance_options = get_option( 'simple_gdpr_cookie_compliance_options' );

		$notice_obj_array = array(
			'cookieExpireTime' => isset( $simple_gdpr_cookie_compliance_options['cookie_expire_time'] ) ? (int) $simple_gdpr_cookie_compliance_options['cookie_expire_time'] : 0,
		);

		if ( is_multisite() ) {
			$notice_obj_array['isMultisite'] = true;
			if ( SUBDOMAIN_INSTALL === false ) {
				$notice_obj_array['subdomainInstall'] = false;
				$notice_obj_array['path']             = get_site()->path;
			} else {
				$notice_obj_array['subdomainInstall'] = true;
			}
		} else {
			$notice_obj_array['isMultisite'] = false;
		}

		wp_localize_script( $this->plugin_name, 'simpleGDPRCCJsObj', $notice_obj_array );

		wp_enqueue_script( $this->plugin_name );
	}

	/**
	 * Prints inline dynamic styles.
	 *
	 * @since 1.0.4
	 */
	public function print_dynamic_style() {

		$dynamic_css = $this->get_dynamic_css();

		wp_add_inline_style( $this->plugin_name, $dynamic_css );
	}

	/**
	 * HTML template for notice displayed in frontend.
	 *
	 * @since    1.0.0
	 */
	public function display_notice() {

		$settings_values = simple_gdpr_cookie_compliance_get_fields_values();

		$options = get_option( 'simple_gdpr_cookie_compliance_options' );

		if ( ! isset( $options['notice_text'] ) && empty( $options['notice_text'] ) ) {
			if ( is_admin() || current_user_can( 'manage_options' ) ) {
				$settings_values['notice_text'] = sprintf(
					/* translators: %s is link to plugin's setting page */
					__( 'Please update this notice text: %1s %2s %3s %4s', 'simple-gdpr-cookie-compliance' ),
					$settings_values['notice_text'],
					'Go to  ',
					'<a href="' . esc_url( admin_url( 'admin.php?page=simple-gdpr-cookie-compliance' ) ) . '">' . esc_html__( 'Dashboard > Simple GDPR', 'simple-gdpr-cookie-compliance' ) . '</a>',
					'to set notice.'
				);
			}
		}

		if ( $settings_values ) {
			$class = '';
			if ( isset( $settings_values['style'] ) ) {

				switch ( $settings_values['style'] ) {
					case 'full_width':
						if ( isset( $settings_values['fullwidth_position'] ) ) {
							$class = 'layout-full ';

							$fullwidth_position = $settings_values['fullwidth_position'];

							if ( 'top' === $fullwidth_position ) {
								$class .= 'position-top';
							} else {
								$class .= 'position-bottom';
							}
						}
						break;
					case 'custom_width':
						if ( isset( $settings_values['customwidth_position'] ) ) {
							$class = 'layout-custom-width ';

							$customwidth_position = $settings_values['customwidth_position'];

							switch ( $customwidth_position ) {
								case 'top_left':
									$class .= 'position-top-left';
									break;
								case 'top_center':
									$class .= 'position-top-center';
									break;
								case 'top_right':
									$class .= 'position-top-right';
									break;
								case 'bottom_left':
									$class .= 'position-bottom-left';
									break;
								case 'bottom_center':
									$class .= 'position-bottom-center';
									break;
								case 'bottom_right':
									$class .= 'position-bottom-right';
									break;
								default:
									break;
							}
						}
						break;
					default:
						$class = 'layout-popup';
				}
			}

			if (
				isset( $settings_values['show_close_btn'] ) &&
				false === $settings_values['show_close_btn']
			) {
				$class .= ' hide-close-btn';
			}

			if (
				isset( $settings_values['show_cookie_icon'] ) &&
				false === $settings_values['show_cookie_icon']
			) {
				$class .= ' hide-cookie-icon';
			}

			$settings_values['wrapper_class'] = $class;
		}

		load_template( plugin_dir_path( __FILE__ ) . 'partials/simple-gdpr-cookie-compliance-public-display.php', true, $settings_values );
	}


	/**
	 * Generate dynamic css code and minifies it.
	 *
	 * @since 1.0.4
	 */
	public function get_dynamic_css() {

		$settings_default = simple_gdpr_get_setting_defaults();

		$dynamic_options = get_option( 'simple_gdpr_cookie_compliance_options' );

		$css = '';

		$css_values = array(
			'--sgcc-text-color'                           => isset( $dynamic_options['color']['notice_text'] ) ? $dynamic_options['color']['notice_text'] : $settings_default['notice_text_color'],
			'--sgcc-link-color'                           => isset( $dynamic_options['color']['notice_link_color'] ) ? $dynamic_options['color']['notice_link_color'] : $settings_default['notice_link_color'],
			'--sgcc-link-hover-color'                     => isset( $dynamic_options['color']['notice_link_hover_color'] ) ? $dynamic_options['color']['notice_link_hover_color'] : $settings_default['notice_link_hover_color'],
			'--sgcc-notice-background-color'              => isset( $dynamic_options['color']['notice_background'] ) ? $dynamic_options['color']['notice_background'] : $settings_default['notice_background'],
			'--sgcc-cookie-icon-color'                    => isset( $dynamic_options['color']['notice_cookie_icon_color'] ) ? $dynamic_options['color']['notice_cookie_icon_color'] : $settings_default['notice_cookie_icon_color'],
			'--sgcc-close-button-background-color'        => isset( $dynamic_options['color']['notice_box_close_btn_bg_color'] ) ? $dynamic_options['color']['notice_box_close_btn_bg_color'] : $settings_default['notice_box_close_btn_bg_color'],
			'--sgcc-close-button-hover-background-color'  => isset( $dynamic_options['color']['notice_box_close_btn_bg_hover_color'] ) ? $dynamic_options['color']['notice_box_close_btn_bg_hover_color'] : $settings_default['notice_box_close_btn_bg_hover_color'],
			'--sgcc-close-button-color'                   => isset( $dynamic_options['color']['notice_box_close_btn_text_color'] ) ? $dynamic_options['color']['notice_box_close_btn_text_color'] : $settings_default['notice_box_close_btn_text_color'],
			'--sgcc-close-button-hover-color'             => isset( $dynamic_options['color']['notice_box_close_btn_hover_text_color'] ) ? $dynamic_options['color']['notice_box_close_btn_hover_text_color'] : $settings_default['notice_box_close_btn_hover_text_color'],
			'--sgcc-accept-button-background-color'       => isset( $dynamic_options['color']['notice_compliance_button_bg'] ) ? $dynamic_options['color']['notice_compliance_button_bg'] : $settings_default['notice_compliance_button_bg'],
			'--sgcc-accept-button-hover-background-color' => isset( $dynamic_options['color']['notice_compliance_button_hover_bg_color'] ) ? $dynamic_options['color']['notice_compliance_button_hover_bg_color'] : $settings_default['notice_compliance_button_hover_bg_color'],
			'--sgcc-accept-button-color'                  => isset( $dynamic_options['color']['notice_compliance_button_text_color'] ) ? $dynamic_options['color']['notice_compliance_button_text_color'] : $settings_default['notice_compliance_button_text_color'],
			'--sgcc-accept-button-hover-color'            => isset( $dynamic_options['color']['notice_compliance_button_hover_text_color'] ) ? $dynamic_options['color']['notice_compliance_button_hover_text_color'] : $settings_default['notice_compliance_button_hover_text_color'],
			'--sgcc-accept-button-border-color'           => isset( $dynamic_options['color']['notice_compliance_button_border_color'] ) ? $dynamic_options['color']['notice_compliance_button_border_color'] : $settings_default['notice_compliance_button_border_color'],
			'--sgcc-accept-button-hover-border-color'     => isset( $dynamic_options['color']['notice_compliance_button_hover_border_color'] ) ? $dynamic_options['color']['notice_compliance_button_hover_border_color'] : $settings_default['notice_compliance_button_hover_border_color'],
		);

		$css = ':root {';

		foreach ( $css_values as $key => $value ) {

			if ( ! is_array( $value ) && ! empty( $value ) ) {
				$css .= $key . ': ' . $value . ';';
			}
		}

		$css .= '}';

		if ( isset( $dynamic_options['style']['type'] ) && 'custom_width' === strtolower( $dynamic_options['style']['type'] ) ) {

			if ( isset( $dynamic_options['style']['width'] ) && ! empty( $dynamic_options['style']['width'] ) ) {
				$css .= '.sgcc-main-wrapper[data-layout=custom_width] {';
				$css .= '--width : ' . $dynamic_options['style']['width'] . 'px;';
				$css .= '}';
			}

			if ( isset( $dynamic_options['style']['customwidth_position'] ) && 'top' === strtolower( $dynamic_options['style']['customwidth_position'] ) ) {
				$css .= '.sgcc-main-wrapper[data-layout=custom_width].position-top-center {';
				$css .= '--top : ' . $dynamic_options['style']['top_offset'] . 'px;';

				$css .= '}';
			} elseif ( isset( $dynamic_options['style']['customwidth_position'] ) && 'top_left' === strtolower( $dynamic_options['style']['customwidth_position'] ) ) {
				$css .= '.sgcc-main-wrapper[data-layout=custom_width].position-top-left {';
				$css .= '--top : ' . $dynamic_options['style']['top_offset'] . 'px;';
				$css .= '--left : ' . $dynamic_options['style']['left_offset'] . 'px;';

				$css .= '}';
			} elseif ( isset( $dynamic_options['style']['customwidth_position'] ) && 'top_right' === strtolower( $dynamic_options['style']['customwidth_position'] ) ) {

				$css .= '.sgcc-main-wrapper[data-layout=custom_width].position-top-right {';
				$css .= '--top : ' . $dynamic_options['style']['top_offset'] . 'px;';
				$css .= '--right : ' . $dynamic_options['style']['right_offset'] . 'px;';

				$css .= '}';
			} elseif ( isset( $dynamic_options['style']['customwidth_position'] ) && 'bottom_left' === strtolower( $dynamic_options['style']['customwidth_position'] ) ) {

				$css .= '.sgcc-main-wrapper[data-layout=custom_width].position-bottom-left {';
				$css .= '--left : ' . $dynamic_options['style']['left_offset'] . 'px;';
				$css .= '--bottom : ' . $dynamic_options['style']['bottom_offset'] . 'px;';

				$css .= '}';
			} elseif ( isset( $dynamic_options['style']['customwidth_position'] ) && 'bottom_center' === strtolower( $dynamic_options['style']['customwidth_position'] ) ) {

				$css .= '.sgcc-main-wrapper[data-layout=custom_width].position-bottom-center {';
				$css .= '--bottom : ' . $dynamic_options['style']['bottom_offset'] . 'px;';

				$css .= '}';
			} elseif ( isset( $dynamic_options['style']['customwidth_position'] ) && 'bottom_right' === strtolower( $dynamic_options['style']['customwidth_position'] ) ) {

				$css .= '.sgcc-main-wrapper[data-layout=custom_width].position-bottom-right {';
				$css .= '--right : ' . $dynamic_options['style']['right_offset'] . 'px;';
				$css .= '--bottom : ' . $dynamic_options['style']['bottom_offset'] . 'px;';

				$css .= '}';
			}
		}
		return $css;
	}

	/**
	 * Add custom CSS from custom css option.
	 */
	public function add_custom_css() {
		$dynamic_options = get_option( 'simple_gdpr_cookie_compliance_options' );
		if ( isset( $dynamic_options['custom_css'] ) ) {
			$custom_css = $this->minify_css( $dynamic_options['custom_css'] );
			?>
			<style>
				<?php echo esc_html( $custom_css ); ?>
			</style>
			<?php
		}
	}

	/**
	 * Simple minification of CSS codes.
	 *
	 * @since    1.0.4
	 *
	 * @param string $css CSS rules.
	 * @return string $css Trimmed CSS rules.
	 */
	private function minify_css( $css ) {
		$css = preg_replace( '/\s+/', ' ', $css );
		$css = preg_replace( '/\/\*[^\!](.*?)\*\//', '', $css );
		$css = preg_replace( '/(,|:|;|\{|}) /', '$1', $css );
		$css = preg_replace( '/ (,|;|\{|})/', '$1', $css );
		$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );
		$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

		return trim( $css );
	}
}
