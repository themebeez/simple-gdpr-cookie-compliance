<?php
/**
 * The class to define REST API endpoints used in settings page.
 *
 * This is used to define REST API endpoints used in admin settings page to get and update settings values.
 *
 * @since      1.0.7
 * @package    simple-gdpr-cookie-compliance
 * @subpackage simple-gdpr-cookie-compliance/includes
 * @author     Addonify <contact@addonify.com>
 */

if ( ! class_exists( 'Class_Simple_GDPR_Cookie_Compliance_Rest_API' ) ) {
	/**
	 * Register rest api.
	 *
	 * @package    simple-gdpr-cookie-compliance
	 * @subpackage simple-gdpr-cookie-compliance/includes
	 * @author     Adodnify <contact@addonify.com>
	 */
	class Class_Simple_GDPR_Cookie_Compliance_Rest_API {

		/**
		 * The namespace of the Rest API.
		 *
		 * @since    1.0.7
		 * @access   protected
		 * @var      string    $rest_namespace.
		 */
		protected $rest_namespace = 'sgcc/v1';

		/**
		 * Register new REST API endpoints.
		 *
		 * @since    1.0.7
		 */
		public function __construct() {

			add_action( 'rest_api_init', array( $this, 'register_rest_endpoints' ) );
		}


		/**
		 * Define the REST API endpoints to get all setting options and update all setting options.
		 *
		 * @since    1.0.7
		 * @access   public
		 */
		public function register_rest_endpoints() {

			register_rest_route(
				$this->rest_namespace,
				'/options',
				array(
					array(
						'methods'             => \WP_REST_Server::READABLE,
						'callback'            => array( $this, 'rest_handler_get_setting_fields' ),
						'permission_callback' => '__return_true',//array( $this, 'permission_callback' ),
					),
				)
			);

			register_rest_route(
				$this->rest_namespace,
				'/options',
				array(
					array(
						'methods'             => \WP_REST_Server::CREATABLE,
						'callback'            => array( $this, 'rest_handler_update_setting_fields' ),
						'permission_callback' => '__return_true',//array( $this, 'permission_callback' ),
					),
				)
			);
		}

		/**
		 * Callback function to get all settings options values.
		 *
		 * @since 1.2.17
		 *
		 * @param \WP_REST_Request $request    The request object.
		 * @return \WP_REST_Response $return_data   The response object.
		 */
		public function rest_handler_get_setting_fields( $request ) {

			$return_data = array(
				'success' => false,
				'message' => esc_html__( 'Oops, error getting settings!!!', 'simple-gdpr-cookie-compliance' ),
			);

			// Check nonce if the request is not a "GET" request.
			// if ( $request->get_method() !== 'GET' ) {
			// 	$nonce = $request->get_header( 'x_wp_admin_nonce' );

			// 	if ( ! $nonce || ! wp_verify_nonce( $nonce, 'simple-gdpr-cookie-compliance-admin-nonce' ) ) {
			// 		$return_data['message'] = esc_html__( 'Invalid security token', 'simple-gdpr-cookie-compliance' );
			// 		return rest_ensure_response( $return_data );
			// 	}
			// }

			$return_data['success'] = true;
			$return_data['message'] = esc_html__( 'successfully fetched data.', 'simple-gdpr-cookie-compliance' );
			$return_data['data']    = simple_gdpr_cookie_compliance_get_settings_sections_fields();

			return rest_ensure_response( $return_data );
		}
	}
}
