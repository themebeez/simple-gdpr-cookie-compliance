<?php
/**
 * The public-facing functionality of the plugin.
 *
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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Simple_GDPR_Cookie_Compliance_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_GDPR_Cookie_Compliance_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if( is_rtl() ) {

			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/build/css/simple-gdpr-cookie-compliance-public-rtl.css', array(), $this->version, 'all' );
		} else {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/build/css/simple-gdpr-cookie-compliance-public.css', array(), $this->version, 'all' );

		}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Simple_GDPR_Cookie_Compliance_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_GDPR_Cookie_Compliance_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/build/js/simple-gdpr-cookie-compliance-public.js', array( 'jquery' ), $this->version, true );

		$simple_gdpr_cookie_compliance_options = get_option( 'simple_gdpr_cookie_compliance_options' );

		$noticeObjArray = array(
			'cookie_expire_time' => 1,
		);

		if( ! empty( $simple_gdpr_cookie_compliance_options['cookie_expire_time'] ) ) {

			$noticeObjArray['cookie_expire_time'] = absint( $simple_gdpr_cookie_compliance_options['cookie_expire_time'] );
		}

		wp_localize_script( $this->plugin_name, 'noticeObj', $noticeObjArray );

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

		$options = get_option( 'simple_gdpr_cookie_compliance_options' );

		$args = array();

		if ( $options ) {
			if ( isset( $options['notice_text'] ) ) {
				$args['notice'] = $options['notice_text'];
			}

			if ( isset( $options['link']['link_type'] ) ) {
				$args['link_type'] = $options['link']['link_type'];
				switch ( $options['link']['link_type'] ) {
					case 'custom_url' :
						if( isset( $options['link']['link_title'] ) ) {
							$args['link_title'] = $options['link']['link_title'];
						}
						if ( isset( $options['link']['link_url'] ) ) {
							$args['link_url'] = $options['link']['link_url'];
						}
						if ( isset( $options['link']['before_link'] ) ) {
							$args['before_link'] = $options['link']['before_link'];
						}
						if ( isset( $options['link']['after_link'] ) ) {
							$args['after_link'] = $options['link']['after_link'];
						}
						break;
					case 'page' :
						if ( isset( $options['link']['page'] ) ) {
							$args['page_title'] = get_the_title( absint( $options['link']['page'] ) );
							$args['page_link'] = get_the_permalink( absint( $options['link']['page'] ) );
						}
						if ( isset( $options['link']['before_link'] ) ) {
							$args['before_link'] = $options['link']['before_link'];
						}
						if ( isset( $options['link']['after_link'] ) ) {
							$args['after_link'] = $options['link']['after_link'];
						}
						break;
					default :
						break;
				}
			}

			if ( isset( $options['show_in_new_tab'] ) ) {
				$args['show_in_new_tab'] = $options['show_in_new_tab'];
			}

			if ( isset( $options['accept_btn_title'] ) ) {
				$args['btn_title'] = $options['accept_btn_title'];
			}

			if ( isset( $options['show_close_btn'] ) ) {
				$args['show_close_btn'] = $options['show_close_btn'];
			}

			if ( isset( $options['show_cookie_icon'] ) ) {
				$args['show_cookie_icon'] = $options['show_cookie_icon'];
			}

			if ( isset( $options['style']['enable_bg_overlay'] ) ) {
				$args['enable_bg_overlay'] = $options['style']['enable_bg_overlay'];
			}

			if ( isset( $options['style']['type'] ) ) {
				$args['notice_type'] = $options['style']['type'];
			}
		}

		$args['wrapper_class'] = $this->get_wrapper_css_class( $options );

		load_template( plugin_dir_path( __FILE__ ) . 'partials/simple-gdpr-cookie-compliance-public-display.php', true, $args );
	}


	/**
	 * Generate CSS classes for HTML elements of notice.
	 *
	 * @since    1.0.4
	 */
	private function get_wrapper_css_class( $options ) {

		if ( $options ) {

			$class = '';

			if ( isset( $options['style']['type'] ) ) {

				switch ( $options['style']['type'] ) {
					case 'full_width' :
						if ( isset( $options['style']['fullwidth_position'] ) ) {
							$class = 's-gdpr-c-c-fullwidth ';
							$fullwidth_position = $options['style']['fullwidth_position'];
							if ( $fullwidth_position == 'top' ) {
								$class .= 's-gdpr-c-c-fullwidth-top';
							} else {
								$class .= 's-gdpr-c-c-fullwidth-bottom';
							}
						}
						break;
					case 'custom_width' :
						if ( isset( $options['style']['customwidth_position'] ) ) {
							$class = 's-gdpr-c-c-customwidth ';
							$customwidth_position = $options['style']['customwidth_position'];
							if ( $customwidth_position == 'top_left' ) {
								$class .= 's-gdpr-c-c-customwidth-top-left';
							} elseif ( $customwidth_position == 'top_center' ) {
								$class .= 's-gdpr-c-c-customwidth-top-center';
							} elseif ( $customwidth_position == 'top_right' ) {
								$class .= 's-gdpr-c-c-customwidth-top-right';
							} elseif ( $customwidth_position == 'bottom_left' ) {
								$class .= 's-gdpr-c-c-customwidth-bottom-left';
							} elseif ( $customwidth_position == 'bottom_center' ) {
								$class .= 's-gdpr-c-c-customwidth-bottom-center';
							} else {
								$class .= 's-gdpr-c-c-customwidth-bottom-right';
							}
						}
						break;
					default :
						$class = 's-gdpr-c-c-pop-up';
				}
			}

			if ( isset( $options['show_close_btn'] ) && $options['show_close_btn'] == false ) {
				$class .= ' s-gdpr-c-c-no-close-btn';
			}

			if ( isset( $options['show_cookie_icon'] ) && $options['show_cookie_icon'] == false ) {
				$class .= ' s-gdpr-c-c-no-cookie-icon';
			}

			return $class;
		}
	}

	/**
	 * Generate dynamic css code and minifies it.
	 *
	 * @since 1.0.4
	 */
	public function get_dynamic_css() {

		$dynamic_options = get_option( 'simple_gdpr_cookie_compliance_options' );

		$css = '';

		if ( isset( $dynamic_options['color']['notice_background'] ) ) {
			$css .= '
				.sgcc-main-wrapper {
					background-color: ' . $dynamic_options['color']['notice_background'] . ';
				}';
		}

		if ( isset( $dynamic_options['color']['notice_text'] ) ) {
			$css .= '
				.sgcc-main-wrapper .sgcc-cookies p {
					color: ' . $dynamic_options['color']['notice_text'] . ';
				}';
		}

		if ( isset( $dynamic_options['color']['notice_link_color'] ) ) {
			$css .= '
				.sgcc-main-wrapper .sgcc-cookies a {
					color: ' . $dynamic_options['color']['notice_link_color'] . ';
				}';
		}

		if ( isset( $dynamic_options['color']['notice_link_hover_color'] ) ) {
			$css .= '
				.sgcc-main-wrapper .sgcc-cookies a:hover {
					color: ' . $dynamic_options['color']['notice_link_hover_color'] . ';
				}';
		}

		if ( isset( $dynamic_options['color']['notice_cookie_icon_color'] ) ) {
			$css .= '
				.sgcc-main-wrapper .sgcc-cookies .cookie-icon {
					color: ' . $dynamic_options['color']['notice_cookie_icon_color'] . ';
				}';
		}

		if ( isset( $dynamic_options['color']['notice_compliance_button_bg'] ) ) {
			$css .= '
				.sgcc-main-wrapper .cookie-compliance-button-block .cookie-compliance-button {
					background-color: ' . $dynamic_options['color']['notice_compliance_button_bg'] . ';
				}';
		}

		if ( isset( $dynamic_options['color']['notice_compliance_button_hover_bg_color'] ) ) {
			$css .= '
				.sgcc-main-wrapper .cookie-compliance-button-block .cookie-compliance-button:hover {
					background-color: ' . $dynamic_options['color']['notice_compliance_button_hover_bg_color'] . ';
				}';
		}

		if ( isset( $dynamic_options['color']['notice_compliance_button_border_color'] ) ) {
			$css .= '
				.sgcc-main-wrapper .cookie-compliance-button-block .cookie-compliance-button {
					border-color: ' . $dynamic_options['color']['notice_compliance_button_border_color'] . ';
				}';
		}

		if ( isset( $dynamic_options['color']['notice_compliance_button_hover_border_color'] ) ) {
			$css .= '
				.sgcc-main-wrapper .cookie-compliance-button-block .cookie-compliance-button:hover {
					border-color: ' . $dynamic_options['color']['notice_compliance_button_hover_border_color'] . ';
				}';
		}

		if ( isset( $dynamic_options['color']['notice_compliance_button_text_color'] ) ) {
			$css .= '
				.sgcc-main-wrapper .cookie-compliance-button-block .cookie-compliance-button {
					color: ' . $dynamic_options['color']['notice_compliance_button_text_color'] . ';
				}';
		}

		if ( isset( $dynamic_options['color']['notice_compliance_button_hover_text_color'] ) ) {
			$css .= '
				.sgcc-main-wrapper .cookie-compliance-button-block .cookie-compliance-button:hover {
					color: ' . $dynamic_options['color']['notice_compliance_button_hover_text_color'] . ';
				}';
		}

		if ( isset( $dynamic_options['color']['notice_box_close_btn_bg_color'] ) ) {
			$css .= '
				.sgcc-main-wrapper .sgcc-cookies .close {
					background-color: ' . $dynamic_options['color']['notice_box_close_btn_bg_color'] . ';
				}';
		}

		if ( isset( $dynamic_options['color']['notice_box_close_btn_bg_hover_color'] ) ) {
			$css .= '
				.sgcc-main-wrapper .sgcc-cookies .close:hover {
					background-color: ' . $dynamic_options['color']['notice_box_close_btn_bg_hover_color'] . ';
				}';
		}

		if ( isset( $dynamic_options['color']['notice_box_close_btn_text_color'] ) ) {
			$css .= '
				.sgcc-main-wrapper .sgcc-cookies .close:hover {
					color: ' . $dynamic_options['color']['notice_box_close_btn_text_color'] . ';
				}';
		}

		if ( isset( $dynamic_options['color']['notice_box_close_btn_hover_text_color'] ) ) {
			$css .= '
				.sgcc-main-wrapper .sgcc-cookies .close:hover {
					color: ' . $dynamic_options['color']['notice_box_close_btn_hover_text_color'] . ';
				}';
		}

		$show_close_btn = ( isset( $dynamic_options['show_close_btn'] ) ) ? $dynamic_options['show_close_btn'] : false;

		$show_cookie_icon = ( isset( $dynamic_options['show_cookie_icon'] ) ) ? $dynamic_options['show_cookie_icon'] : false;

		if ( isset( $dynamic_options['style']['type'] ) ) {

			// Dynamic CSS for pop-up notice.

			if ( $dynamic_options['style']['type'] == 'pop_up' ) {

				if ( isset( $dynamic_options['style']['enable_bg_overlay'] ) && $dynamic_options['style']['enable_bg_overlay'] == true ) {
					$css .= '
					.s-gdpr-c-c-bg-overlay {
						position: fixed;
						top: 0;
						right: 0;
						bottom: 0;
						left: 0;
						z-index: 99999998;
						-webkit-transition: all 0.5s ease;
    					-moz-transition: all 0.5s ease;
    					-ms-transition: all 0.5s ease;
    					-o-transition: all 0.5s ease;
    					transition: all 0.5s ease;
					';

					if ( isset( $dynamic_options['color']['notice_bg_overlay_color'] ) ) {
						$css .= '
							background-color: ' . $dynamic_options['color']['notice_bg_overlay_color'] . ';
						';
					}

					$css .= '}';
				}

				$width = null;

				if ( isset( $dynamic_options['style']['width'] ) ) {

					$width = $dynamic_options['style']['width'];

					$css .= '
						.s-gdpr-c-c-pop-up {
							width: ' . $width . 'px;
						}';	
				}

				$css .= '
					.s-gdpr-c-c-pop-up {
						position: fixed;
						z-index: 99999999;
  						left: 50%;
  						top: 50%;
  						right:unset;
  						bottom:unset;
						-webkit-transform: translate(-50%, -50%);
  						transform: translate(-50%, -50%);
  						-webkit-animation: none;
    					animation:none;
					}';

				if ( ! $show_cookie_icon ) {
					$css .= '
					.sgcc-main-wrapper.s-gdpr-c-c-no-cookie-icon .sgcc-cookies {
						padding: 30px;
					}
					';
				} else {
					$css .= '
					.sgcc-main-wrapper .sgcc-cookies {
						padding: 30px 30px 30px 55px;
					}
					';
				}

				if ( isset( $dynamic_options['style']['enable_bg_overlay'] ) && isset( $dynamic_options['color']['notice_bg_overlay_color'] ) ) {
					$css .= '
						.s-gdpr-c-c-bg-overlay {
							background-color: ' . $dynamic_options['color']['notice_bg_overlay_color'] . ';
						}';	
				}
			}


			// Dynamic CSS for full-width notice.

			if ( $dynamic_options['style']['type'] == 'full_width' ) {

				if ( isset( $dynamic_options['style']['fullwidth_position'] ) ) {

					$css .= '
						.s-gdpr-c-c-fullwidth {
							left: 0;
							right: 0;
							width: 100%;
							border-radius: 0;
							-webkit-animation:none;
							-moz-animation:none;
							animation:none;
    						-webkit-box-shadow: none;
    						-ms-box-shadow: none;
    						box-shadow: none;
						}';

					if ( ! $show_cookie_icon ) {
						$css .= '
						.sgcc-main-wrapper.s-gdpr-c-c-no-cookie-icon .sgcc-cookies {
							padding: 10px;
						}
						';
					} else {
						$css .= '
						.sgcc-main-wrapper .sgcc-cookies {
							padding: 10px 10px 10px 55px;
						}
						';
					}

					$css .= '
						.sgcc-main-wrapper .sgcc-cookies .cookie-icon {
							position: relative;
							top: unset;
							right: unset;
							bottom: unset;
							left: unset;
							margin-right: 15px;
						}
						.sgcc-main-wrapper .sgcc-cookies .close {
							right: 15px;
							top: 50%;
							transform: translateY(-50%);
						}
						.s-gdpr-c-c-fullwidth .sgcc-notice-content {
							display: -webkit-box;
						    display: -ms-flexbox;
						    display: flex;
						    -webkit-box-orient: horizontal;
						    -webkit-box-direction: normal;
						    -ms-flex-direction: row;
						    flex-direction: row;
						    -ms-flex-wrap: wrap;
						    flex-wrap: wrap;
						    -webkit-box-align: center;
						    -ms-flex-align: center;
						    align-items: center;
						    justify-content: center;
						}
						.s-gdpr-c-c-fullwidth .sgcc-notice-content .message-block {
							margin-bottom: 0px;
						}

						.sgcc-main-wrapper.s-gdpr-c-c-fullwidth .sgcc-cookies p {

							line-height:1.3;
						}

						.sgcc-main-wrapper.s-gdpr-c-c-fullwidth .cookie-compliance-button-block .cookie-compliance-button {
							padding: 10px 15px;
    						border-radius: 2px;
    						-webkit-box-shadow: none;
    						-ms-box-shadow: none;
    						box-shadow: none;
						}

						.s-gdpr-c-c-fullwidth .sgcc-notice-content .cookie-compliance-button-block {
							margin-left: 15px;
						}

						@media(max-width:600px) {
							.sgcc-main-wrapper.s-gdpr-c-c-fullwidth {
								max-width:100%;
							}

							.sgcc-main-wrapper.s-gdpr-c-c-fullwidth .sgcc-cookies {
								padding:10px 15px;
							}

							.sgcc-main-wrapper.s-gdpr-c-c-fullwidth .sgcc-cookies .close,
							.sgcc-main-wrapper.s-gdpr-c-c-fullwidth .sgcc-cookies .cookie-icon {
								display:none;
							}

							.s-gdpr-c-c-fullwidth .sgcc-notice-content .cookie-compliance-button-block {
								margin-left:0;
								margin-top:10px;
							}
						}';

					if ( $dynamic_options['style']['fullwidth_position'] == 'top' ) {
						$css .= '
							.s-gdpr-c-c-fullwidth-top {
								top: 0;
								bottom: auto;
							}';
					}

					if ( $dynamic_options['style']['fullwidth_position'] == 'bottom' ) {
						$css .= '
							.s-gdpr-c-c-fullwidth-bottom {
								bottom: 0;
								top: auto;
							}';
					}
				}
			}


			// Dynamic CSS for custom-width notice.

			if ( $dynamic_options['style']['type'] == 'custom_width' ) {

				$width = null;

				if ( isset( $dynamic_options['style']['width'] ) ) {

					$width = $dynamic_options['style']['width'];

					$css .= '
						.s-gdpr-c-c-customwidth {
							width: ' . $width . 'px;
						}';	
				}

				if ( ! $show_cookie_icon ) {
					$css .= '
					.sgcc-main-wrapper.s-gdpr-c-c-no-cookie-icon .sgcc-cookies {
						padding: 20px;
					}
					';
				} else {
					$css .= '
					.sgcc-main-wrapper .sgcc-cookies {
						padding: 20px 20px 20px 55px;
					}
					';
				}

				if ( isset( $dynamic_options['style']['customwidth_position'] ) ) {

					if ( $dynamic_options['style']['customwidth_position'] == 'top_left' && isset( $dynamic_options['style']['top_offset'] ) && isset( $dynamic_options['style']['left_offset'] ) ) {
						$css .= '
							.s-gdpr-c-c-customwidth-top-left {
								top: ' . $dynamic_options['style']['top_offset'] . 'px;
								left: ' . $dynamic_options['style']['left_offset'] . 'px;
								right: auto;
								bottom: auto;
							}';
					}

					if ( $dynamic_options['style']['customwidth_position'] == 'top_center' && isset( $dynamic_options['style']['top_offset'] ) ) {
						$css .= '
							.s-gdpr-c-c-customwidth-top-center {
								top: ' . $dynamic_options['style']['top_offset'] . 'px;
								left:  calc(50% - ' . (int) $width / 2 . 'px);
								right: auto;
								bottom: auto;
							}';
					}

					if ( $dynamic_options['style']['customwidth_position'] == 'top_right' && isset( $dynamic_options['style']['top_offset'] ) && isset( $dynamic_options['style']['right_offset'] ) ) {
						$css .= '
							.s-gdpr-c-c-customwidth-top-right {
								top: ' . $dynamic_options['style']['top_offset'] . 'px;
								right: ' . $dynamic_options['style']['right_offset'] . 'px;
								left: auto;
								bottom: auto;
							}';
					}

					if ( $dynamic_options['style']['customwidth_position'] == 'bottom_left' && isset( $dynamic_options['style']['bottom_offset'] ) && isset( $dynamic_options['style']['left_offset'] ) ) {
						$css .= '
							.s-gdpr-c-c-customwidth-bottom-left {
								bottom: ' . $dynamic_options['style']['bottom_offset'] . 'px;
								left: ' . $dynamic_options['style']['left_offset'] . 'px;
								right: auto;
								top: auto;
							}';
					}

					if ( $dynamic_options['style']['customwidth_position'] == 'bottom_center' && isset( $dynamic_options['style']['bottom_offset'] ) ) {
						$css .= '
							.s-gdpr-c-c-customwidth-bottom-center {
								bottom: ' . $dynamic_options['style']['bottom_offset'] . 'px;
								left:  calc(50% - ' . (int) $width / 2 . 'px);
								right: auto;
								top: auto;
							}';
					}

					if ( $dynamic_options['style']['customwidth_position'] == 'bottom_right' && isset( $dynamic_options['style']['bottom_offset'] ) && isset( $dynamic_options['style']['right_offset'] ) ) {
						$css .= '
							.s-gdpr-c-c-customwidth-bottom-right {
								bottom: ' . $dynamic_options['style']['bottom_offset'] . 'px;
								right: ' . $dynamic_options['style']['right_offset'] . 'px;
								left: auto;
								top: auto;
							}';
					}
				}
			}
		}


		// Add custom CSS from custom css option.

		if ( isset( $dynamic_options['custom_css'] ) ) {
			$css .= $dynamic_options['custom_css'];
		}

		// Allow CSS to be filtered.
		$css = apply_filters( 'simple_gdpr_cookie_compliance_dynamic_css', $css ); 

		// Minify the CSS code.
		$css = $this->minify_css( $css );

		return $css;
	}

	/**
	 * Simple minification of CSS codes.
	 *
	 * @since    1.0.4
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
