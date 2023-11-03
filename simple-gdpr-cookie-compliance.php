<?php
/**
 * Simple GDPR Cookie Compliance
 *
 * @link              https://themebeez.com/
 * @since             1.0.0
 * @package           Simple_GDPR_Cookie_Compliance
 *
 * Plugin Name:       Simple GDPR Cookie Compliance
 * Plugin URI:        https://themebeez.com/plugins/simple-gdpr-cookie-compliance
 * Description:       Simple GDPR Cookie Compliance is a simple plugin that helps to display cookie notice on your WordPress website.
 * Version:           1.1.7
 * Author:            themebeez
 * Author URI:        https://themebeez.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       simple-gdpr-cookie-compliance
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SIMPLE_GDPR_COOKIE_COMPLIANCE_VERSION', '1.1.7' );
define( 'SIMPLE_GDPR_COOKIE_COMPLIANCE_BASENAME', plugin_basename( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-simple-gdpr-cookie-compliance-activator.php
 */
function activate_simple_gdpr_cookie_compliance() {

	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-gdpr-cookie-compliance-activator.php';

	$activator = new Simple_GDPR_Cookie_Compliance_Activator();

	$activator->activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-simple-gdpr-cookie-compliance-deactivator.php
 */
function deactivate_simple_gdpr_cookie_compliance() {

	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-gdpr-cookie-compliance-deactivator.php';

	Simple_GDPR_Cookie_Compliance_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_simple_gdpr_cookie_compliance' );
register_deactivation_hook( __FILE__, 'deactivate_simple_gdpr_cookie_compliance' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-simple-gdpr-cookie-compliance.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function simple_gdpr_cookie_compliance_start() {

	$plugin = new Simple_GDPR_Cookie_Compliance();
	$plugin->run();
}
simple_gdpr_cookie_compliance_start();
