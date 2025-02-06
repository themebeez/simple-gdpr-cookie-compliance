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

		global $pagenow;

		if (
			'admin.php' === $pagenow &&
			(
				isset( $_GET['page'] ) && // phpcs:ignore
				'simple-gdpr-cookie-compliance' == sanitize_text_field( wp_unslash( $_GET['page'] ) ) // phpcs:ignore
			)
		) {
			?>
			<div id="simple-gdpr-cookie-compliance-app"></div>
			<?php
		}
	}

	/**
	 * Register plugin page links.
	 *
	 * @since    1.0.4
	 *
	 * @param array $links Plugin action links.
	 * @return array
	 */
	public function plugin_page_links( $links ) {

		$action_links = array(
			'settings' => '<a href="' . esc_url( admin_url( 'admin.php?page=simple-gdpr-cookie-compliance' ) ) . '">' . esc_html__( 'Settings', 'simple-gdpr-cookie-compliance' ) . '</a>',
		);

		return array_merge( $action_links, $links );
	}

	/**
	 * Show row meta on the plugin screen.
	 *
	 * @param mixed $links Plugin Row Meta.
	 * @param mixed $file  Plugin Base file.
	 *
	 * @return array
	 */
	public function plugin_row_meta( $links, $file ) {

		if ( SIMPLE_GDPR_COOKIE_COMPLIANCE_BASENAME !== $file ) {
			return $links;
		}

		$row_meta = array(
			'github'  => '<a href="https://github.com/themebeez/simple-gdpr-cookie-compliance" aria-label="' . esc_attr__( 'View Simple GDPR Cookie Compliance GitHub link', 'simple-gdpr-cookie-compliance' ) . '" target="_blank">' . esc_html__( 'GitHub', 'simple-gdpr-cookie-compliance' ) . '</a>',
			'support' => '<a href="https://wordpress.org/support/plugin/simple-gdpr-cookie-compliance/" aria-label="' . esc_attr__( 'Visit community forums', 'simple-gdpr-cookie-compliance' ) . '" target="_blank">' . esc_html__( 'Community support', 'simple-gdpr-cookie-compliance' ) . '</a>',
		);

		return array_merge( $links, $row_meta );
	}
}
