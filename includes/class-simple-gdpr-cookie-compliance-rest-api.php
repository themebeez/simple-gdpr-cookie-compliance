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

if ( ! class_exists( 'Simple_GDPR_Cookie_Compliance_Rest_API' ) ) {
	/**
	 * Register rest api.
	 *
	 * @package    simple-gdpr-cookie-compliance
	 * @subpackage simple-gdpr-cookie-compliance/includes
	 * @author     Adodnify <contact@addonify.com>
	 */
	class Simple_GDPR_Cookie_Compliance_Rest_API {

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
						'permission_callback' => array( $this, 'permission_callback' ),
					),
				)
			);

			register_rest_route(
				$this->rest_namespace,
				'/options',
				array(
					array(
						'methods'             => 'PATCH',
						'callback'            => array( $this, 'rest_handler_update_setting_fields' ),
						'permission_callback' => array( $this, 'permission_callback' ),
					),
				)
			);
		}

		/**
		 * Callback function to get all settings options values.
		 *
		 * @since 1.2.17
		 *
		 * @return \WP_REST_Response $return_data   The response object.
		 */
		public function rest_handler_get_setting_fields() {

			$return_data = array(
				'success' => false,
				'message' => esc_html__( 'Oops, error getting settings!!!', 'simple-gdpr-cookie-compliance' ),
			);

			$return_data['success'] = true;
			$return_data['message'] = esc_html__( 'successfully fetched data.', 'simple-gdpr-cookie-compliance' );
			$return_data['data']    = simple_gdpr_cookie_compliance_get_settings_sections_fields();

			return rest_ensure_response( $return_data );
		}

		/**
		 * Callback function to update all settings options values.
		 *
		 * @since    1.1.11
		 * @param    \WP_REST_Request $request    The request object.
		 * @return   \WP_REST_Response   $return_data   The response object.
		 */
		public function rest_handler_update_setting_fields( $request ) {
			$return_data = array(
				'success' => false,
				'message' => esc_html__( 'Ooops, error saving settings!!!', 'simple-gdpr-cookie-compliance' ),
			);

			$params = $request->get_params();

			$values = json_decode( $params[0], true );

			// Checking if data is comming from request.
			if ( ! isset( $values ) ) {
				return new WP_Error(
					'rest_post_not_found',
					esc_html__( 'No settings to update.', 'simple-gdpr-cookie-compliance' ),
					array( 'status' => 404 )
				);
			}

			if ( simple_gdpr_cookie_compliance_update_settings( $values ) === true ) {

				$return_data['success'] = true;
				$return_data['message'] = esc_html__( 'Settings saved successfully', 'simple-gdpr-cookie-compliance' );
			}

			return rest_ensure_response( $return_data );
		}

		/**
		 * Permission callback function to check if current user can access the rest api route.
		 *
		 * @since    1.0.7
		 */
		public function permission_callback() {

			if ( ! current_user_can( 'manage_options' ) ) {

				return new WP_Error( 'rest_forbidden', esc_html__( 'Ooops, you are allowed to manage options.', 'simple-gdpr-cookie-compliance' ), array( 'status' => 401 ) );
			}
			return true;
		}
	}
}
