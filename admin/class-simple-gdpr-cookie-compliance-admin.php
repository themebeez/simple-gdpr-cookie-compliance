<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Simple_GDPR_Cookie_Compliance
 * @subpackage Simple_GDPR_Cookie_Compliance/admin
 * @author     themebeez <themebeez@gmail.com>
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Simple_GDPR_Cookie_Compliance
 * @subpackage Simple_GDPR_Cookie_Compliance/admin
 * @author     themebeez <themebeez@gmail.com>
 */
class Simple_GDPR_Cookie_Compliance_Admin {

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
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
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

		global $pagenow;

		if (
			'admin.php' === $pagenow &&
			(
				isset( $_GET['page'] ) && // phpcs:ignore
				'simple-gdpr-cookie-compliance' == sanitize_text_field( wp_unslash( $_GET['page'] ) ) // phpcs:ignore
			)
		) {

			wp_enqueue_style( 'wp-color-picker' );

			wp_enqueue_style(
				$this->plugin_name,
				plugin_dir_url( __FILE__ ) . 'css/simple-gdpr-cookie-compliance-admin.css',
				array(),
				$this->version,
				'all'
			);
		}

	}

	/**
	 * Register the JavaScript for the admin area.
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

		global $pagenow;

		if (
			'admin.php' === $pagenow &&
			(
				isset( $_GET['page'] ) && // phpcs:ignore
				'simple-gdpr-cookie-compliance' == sanitize_text_field( wp_unslash( $_GET['page'] ) ) // phpcs:ignore
			)
		) {

			wp_enqueue_script( 'wp-color-picker' );

			wp_enqueue_script(
				'wp-color-picker-alpha',
				plugin_dir_url( __FILE__ ) . 'js/wp-color-picker-alpha.js',
				array( 'jquery', 'wp-color-picker' ),
				$this->version,
				false
			);

			wp_enqueue_script(
				$this->plugin_name,
				plugin_dir_url( __FILE__ ) . 'js/simple-gdpr-cookie-compliance-admin.js',
				array( 'jquery' ),
				$this->version,
				false
			);
		}

	}

	/**
	 * Register plugin menu in dashboard.
	 *
	 * @since    1.0.0
	 */
	public function plugin_menu() {

		add_menu_page(
			esc_html__( 'Simple GDPR Cookie Compliance', 'simple-gdpr-cookie-compliance' ),
			esc_html__( 'Simple GDPR', 'simple-gdpr-cookie-compliance' ),
			'manage_options',
			'simple-gdpr-cookie-compliance',
			array( $this, 'plugin_page' ),
			'dashicons-lock'
		);
	}

	/**
	 * Register plugin page.
	 *
	 * @since    1.0.0
	 */
	public function plugin_page() {

		require_once plugin_dir_path( __FILE__ ) . 'partials/simple-gdpr-cookie-compliance-admin-page.php';
	}

	/**
	 * Register plugin page links.
	 *
	 * @since    1.0.4
	 *
	 * @param array $actions Actions.
	 */
	public function plugin_page_links( $actions ) {

		$actions[] = '<a href="' . esc_url( admin_url( 'admin.php?page=simple-gdpr-cookie-compliance' ) ) . '">' . esc_html__( 'Settings', 'simple-gdpr-cookie-compliance' ) . '</a>';

		return $actions;
	}
}
