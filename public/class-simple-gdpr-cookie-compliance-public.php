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
	 * HTML template for notice displayed in frontend.
	 *
	 * @since    1.0.0
	 */
	public function display_notice() {

		require_once plugin_dir_path( __FILE__ ) . 'partials/simple-gdpr-cookie-compliance-public-display.php';
	}

	/**
	 * Register the dynamic stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function dynamic_style() {

		$simple_gdpr_cookie_compliance_options = get_option( 'simple_gdpr_cookie_compliance_options' );

		$notice_background = ! empty( $simple_gdpr_cookie_compliance_options['color']['notice_background'] ) ? $simple_gdpr_cookie_compliance_options['color']['notice_background'] : '#fbf01e';

		$notice_text_color = ! empty( $simple_gdpr_cookie_compliance_options['color']['notice_text'] ) ? $simple_gdpr_cookie_compliance_options['color']['notice_text'] : '#222222';

		$notice_link_color = ! empty( $simple_gdpr_cookie_compliance_options['color']['notice_link_color'] ) ? $simple_gdpr_cookie_compliance_options['color']['notice_link_color'] : '#222222';

		$notice_link_hover_color = ! empty( $simple_gdpr_cookie_compliance_options['color']['notice_link_hover_color'] ) ? $simple_gdpr_cookie_compliance_options['color']['notice_link_hover_color'] : '#6c83fb';

		// added on update 1.0.1

		$notice_cookie_icon_color = ! empty( $simple_gdpr_cookie_compliance_options['color']['notice_cookie_icon_color'] ) ? $simple_gdpr_cookie_compliance_options['color']['notice_cookie_icon_color'] : '#222222';

		$notice_compliance_button_bg = ! empty( $simple_gdpr_cookie_compliance_options['color']['notice_compliance_button_bg'] ) ? $simple_gdpr_cookie_compliance_options['color']['notice_compliance_button_bg'] : '#222222';

		$notice_compliance_button_hover_bg_color = ! empty( $simple_gdpr_cookie_compliance_options['color']['notice_compliance_button_hover_bg_color'] ) ? $simple_gdpr_cookie_compliance_options['color']['notice_compliance_button_hover_bg_color'] : '#4cc500';

		$notice_compliance_button_border_color = ! empty( $simple_gdpr_cookie_compliance_options['color']['notice_compliance_button_border_color'] ) ? $simple_gdpr_cookie_compliance_options['color']['notice_compliance_button_border_color'] : '#222222';

		$notice_compliance_button_hover_border_color = ! empty( $simple_gdpr_cookie_compliance_options['color']['notice_compliance_button_hover_border_color'] ) ? $simple_gdpr_cookie_compliance_options['color']['notice_compliance_button_hover_border_color'] : '#4cc500';

		$notice_compliance_button_text_color = ! empty( $simple_gdpr_cookie_compliance_options['color']['notice_compliance_button_text_color'] ) ? $simple_gdpr_cookie_compliance_options['color']['notice_compliance_button_text_color'] : '#ffffff';

		$notice_compliance_button_hover_text_color = ! empty( $simple_gdpr_cookie_compliance_options['color']['notice_compliance_button_hover_text_color'] ) ? $simple_gdpr_cookie_compliance_options['color']['notice_compliance_button_hover_text_color'] : '#ffffff';

		$notice_box_close_btn_bg_color = ! empty( $simple_gdpr_cookie_compliance_options['color']['notice_box_close_btn_bg_color'] ) ? $simple_gdpr_cookie_compliance_options['color']['notice_box_close_btn_bg_color'] : '#222222';

		$notice_box_close_btn_bg_hover_color = ! empty( $simple_gdpr_cookie_compliance_options['color']['notice_box_close_btn_bg_hover_color'] ) ? $simple_gdpr_cookie_compliance_options['color']['notice_box_close_btn_bg_hover_color'] : '#4cc500';

		$notice_box_close_btn_text_color = ! empty( $simple_gdpr_cookie_compliance_options['color']['notice_box_close_btn_text_color'] ) ? $simple_gdpr_cookie_compliance_options['color']['notice_box_close_btn_text_color'] : '#ffffff';

		$notice_box_close_btn_hover_text_color = ! empty( $simple_gdpr_cookie_compliance_options['color']['notice_box_close_btn_hover_text_color'] ) ? $simple_gdpr_cookie_compliance_options['color']['notice_box_close_btn_hover_text_color'] : '#ffffff';
		
		?>
		<style>
			<?php
			if( ! empty( $notice_background ) ) {
				?>
				.sgcc-main-wrapper {
          
					background-color: <?php echo esc_attr( $notice_background ); ?>;
				}
				<?php
			}

			if( ! empty( $notice_text_color ) ) {
				?>
				.sgcc-main-wrapper .sgcc-cookies p {
          
					color: <?php echo esc_attr( $notice_text_color ); ?>;
				}
				<?php
			}

			if( ! empty( $notice_link_color ) ) {
				?>
				.sgcc-main-wrapper .sgcc-cookies a {

					color: <?php echo esc_attr( $notice_link_color ); ?>;
				}
				<?php
			}

			if( ! empty( $notice_link_hover_color ) ) {
				?>
				.sgcc-main-wrapper .sgcc-cookies a:hover {

					color: <?php echo esc_attr( $notice_link_hover_color ); ?>;
				}
				<?php
			}

			// added on update 1.0.1

			if( ! empty( $notice_cookie_icon_color ) ) {
				?>
				.sgcc-main-wrapper .sgcc-cookies .cookie-icon {

					color: <?php echo esc_attr( $notice_cookie_icon_color ); ?>;
				}
				<?php
			}

			if( ! empty( $notice_compliance_button_bg ) ) {
				?>
				.sgcc-main-wrapper .cookie-compliance-button-block .cookie-compliance-button {

					background-color: <?php echo esc_attr( $notice_compliance_button_bg ); ?>;
				}
				<?php
			}

			if( ! empty( $notice_compliance_button_hover_bg_color ) ) {
				?>
				.sgcc-main-wrapper .cookie-compliance-button-block .cookie-compliance-button:hover {

					background-color: <?php echo esc_attr( $notice_compliance_button_hover_bg_color ); ?>;
				}
				<?php
			}

			if( ! empty( $notice_compliance_button_border_color ) ) {
				?>
				.sgcc-main-wrapper .cookie-compliance-button-block .cookie-compliance-button {

					border-color: <?php echo esc_attr( $notice_compliance_button_border_color ); ?>;
				}
				<?php
			}

			if( ! empty( $notice_compliance_button_hover_border_color ) ) {
				?>
				.sgcc-main-wrapper .cookie-compliance-button-block .cookie-compliance-button:hover {

					border-color: <?php echo esc_attr( $notice_compliance_button_hover_border_color ); ?>;
				}
				<?php
			}

			if( ! empty( $notice_compliance_button_text_color ) ) {
				?>
				.sgcc-main-wrapper .cookie-compliance-button-block .cookie-compliance-button {

					color: <?php echo esc_attr( $notice_compliance_button_text_color ); ?>;
				}
				<?php
			}

			if( ! empty( $notice_compliance_button_hover_text_color ) ) {
				?>
				.sgcc-main-wrapper .cookie-compliance-button-block .cookie-compliance-button:hover {

					color: <?php echo esc_attr( $notice_compliance_button_hover_text_color ); ?>;
				}
				<?php
			}

			if( ! empty( $notice_box_close_btn_bg_color ) ) {
				?>
				.sgcc-main-wrapper .sgcc-cookies .close {

					background-color: <?php echo esc_attr( $notice_box_close_btn_bg_color ); ?>;
				}
				<?php
			}

			if( ! empty( $notice_box_close_btn_bg_hover_color ) ) {
				?>
				.sgcc-main-wrapper .sgcc-cookies .close:hover {

					background-color: <?php echo esc_attr( $notice_box_close_btn_bg_hover_color ); ?>;
				}
				<?php
			}

			if( ! empty( $notice_box_close_btn_text_color ) ) {
				?>
				.sgcc-main-wrapper .sgcc-cookies .close {

					color: <?php echo esc_attr( $notice_box_close_btn_text_color ); ?>;
				}
				<?php
			}

			if( ! empty( $notice_box_close_btn_hover_text_color ) ) {
				?>
				.sgcc-main-wrapper .sgcc-cookies .close:hover {

					color: <?php echo esc_attr( $notice_box_close_btn_hover_text_color ); ?>;
				}
				<?php
			}
			?>
		</style>
		<?php
	}
}
