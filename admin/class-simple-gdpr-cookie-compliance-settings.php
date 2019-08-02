<?php
/**
 * The admin-settings functionality of the plugin.
 *
 * @package    Simple_GDPR_Cookie_Compliance
 * @subpackage Simple_GDPR_Cookie_Compliance/admin
 * @author     themebeez <themebeez@gmail.com>
 */

class Simple_GDPR_Cookie_Compliance_Admin_Settings {

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
	 * The options of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		if( get_option( 'simple_gdpr_cookie_compliance_options' ) ) {

			$this->options = get_option( 'simple_gdpr_cookie_compliance_options' );
		}
	}

	/**
	 * Register register settings.
	 *
	 * @since    1.0.0
	 */
	public function register_settings() {

		register_setting( 'simple_gdpr_cookie_compliance_settings', // Option Group ID
			'simple_gdpr_cookie_compliance_options', // Settings ID
			array( $this, 'sanitize_fields' ) // Sanitization Callback
		);

		add_settings_section( 'simple_gdpr_cookie_compliance_fields_section', // Section ID
			__( 'Configure Settings', 'simple-gdpr-cookie-compliance' ), // Section Title
			array( $this, 'section_callback' ), // Section Callback
			'simple_gdpr_cookie_compliance_settings' // Option Group ID
		);

		add_settings_field( 's_gdpr_c_n_notice_text', 
			__( 'Notice', 'simple-gdpr-cookie-compliance' ), 
			array( $this, 'notice_field' ), 
			'simple_gdpr_cookie_compliance_settings', 
			'simple_gdpr_cookie_compliance_fields_section' 
		);

		add_settings_field( 's_gdpr_c_n_link', 
			__( 'Link', 'simple-gdpr-cookie-compliance' ), 
			array( $this, 'link_fields' ), 
			'simple_gdpr_cookie_compliance_settings', 
			'simple_gdpr_cookie_compliance_fields_section' 
		);

		add_settings_field( 's_gdpr_c_n_cookie', 
			__( 'Cookie', 'simple-gdpr-cookie-compliance' ), 
			array( $this, 'cookie_fields' ), 
			'simple_gdpr_cookie_compliance_settings', 
			'simple_gdpr_cookie_compliance_fields_section' 
		);

		add_settings_field( 's_gdpr_c_n_colors', 
			__( 'Colors', 'simple-gdpr-cookie-compliance' ), 
			array( $this, 'color_fields' ), 
			'simple_gdpr_cookie_compliance_settings', 
			'simple_gdpr_cookie_compliance_fields_section' 
		);
	}

	/**
	 * Register fields section callback.
	 *
	 * @since    1.0.0
	 */
	public function section_callback() {

	}

	/**
	 * Notice setting field.
	 *
	 * @since    1.0.0
	 */
	public function notice_field() {

		$notice = ! empty( $this->options['notice_text'] ) ? $this->options['notice_text'] : __( 'By continuing to use the site, you agree to the use of cookies.', 'simple-gdpr-cookie-compliance' );
		?>
		<div class="s_gdpr_c_n_field" id="s_gdpr_c_n_notice_text">
			<p>
				<textarea name="simple_gdpr_cookie_compliance_options[notice_text]" class="s_gdpr_c_n_textarea" cols="50" rows="5"><?php echo wp_kses_post( $notice ); ?></textarea>
				<small class="description"><?php echo __( 'Enter the notice message. You can also insert &lt;span class=&quot;..&quot;&gt;...&lt;/span&gt;, &lt;a href=&quot;..&quot; target=&quot;..&quot; class=&quot;..&quot; title=&quot;..&quot;&gt;...&lt;/a&gt;, and &lt;i class=&quot;..&quot;&gt;...&lt;/i&gt; HTML tags along with the message.', 'simple-gdpr-cookie-compliance' ); ?></small>
			</p>
		</div>
		<?php
	}

	/**
	 * Link setting fields.
	 *
	 * @since    1.0.0
	 */
	public function link_fields() {

		$link_title = ! empty( $this->options['link']['link_title'] ) ? $this->options['link']['link_title'] : __( 'More Information', 'simple-gdpr-cookie-compliance' );
		$link_url = ! empty( $this->options['link']['link_url'] ) ? $this->options['link']['link_url'] : '';
		?>
		<div class="s_gdpr_c_n_field" id="s_gdpr_c_n_link">
			<p>
				<label for="simple_gdpr_cookie_compliance_options[link][link_title]"><?php _e( 'Title', 'simple-gdpr-cookie-compliance' ); ?></label>
				<input type="text" id="simple_gdpr_cookie_compliance_options[link][link_title]" name="simple_gdpr_cookie_compliance_options[link][link_title]" class="s_gdpr_c_n_text" value="<?php echo esc_attr( $link_title ); ?>">
			</p>
			<p>
				<label for="simple_gdpr_cookie_compliance_options[link][link_url]"><?php _e( 'URL', 'simple-gdpr-cookie-compliance' ); ?></label>
				<input type="text" id="simple_gdpr_cookie_compliance_options[link][link_url]" name="simple_gdpr_cookie_compliance_options[link][link_url]" class="s_gdpr_c_n_text" value="<?php echo esc_attr( $link_url ); ?>">
			</p>
		</div>
		<?php
	}

	/**
	 * Cookie setting fields.
	 *
	 * @since    1.0.0
	 */
	public function cookie_fields() {

		$cookie_expire_time = ! empty( $this->options['cookie_expire_time'] ) ? $this->options['cookie_expire_time'] : 1;
		?>
		<div class="s_gdpr_c_n_field" id="s_gdpr_c_n_cookie">
			<p>
				<label for="simple_gdpr_cookie_compliance_options[cookie_expire_time]"><?php _e( 'Expire Time', 'simple-gdpr-cookie-compliance' ); ?></label>
				<input type="number" id="simple_gdpr_cookie_compliance_options[cookie_expire_time]" name="simple_gdpr_cookie_compliance_options[cookie_expire_time]" class="s_gdpr_c_n_number" value="<?php echo esc_attr( $cookie_expire_time ); ?>">
				<small><?php _e( 'Cookie expire time is in number of days. For example, if you set Expire Time to 1 then, cookie will expire after a day.', 'simple-gdpr-cookie-compliance' ); ?></small>
			</p>
		<?php
	}

	/**
	 * Color setting fields.
	 *
	 * @since    1.0.0
	 */
	public function color_fields() {


		$notice_background_color = ! empty( $this->options['color']['notice_background'] ) ? $this->options['color']['notice_background'] : '#ffb5b5';
		$notice_text_color = ! empty( $this->options['color']['notice_text'] ) ? $this->options['color']['notice_text'] : '#444444';
		$notice_link_color = ! empty( $this->options['color']['notice_link_color'] ) ? $this->options['color']['notice_link_color'] : '#ff4249';
		$notice_link_hover_color = ! empty( $this->options['color']['notice_link_hover_color'] ) ? $this->options['color']['notice_link_hover_color'] : '#6c83fb';
		?>
		<div class="s_gdpr_c_n_field" id="s_gdpr_c_n_link">
			<p>
				<label for="simple_gdpr_cookie_compliance_options[color][notice_background]"><?php _e( 'Notice -  Background Color', 'simple-gdpr-cookie-compliance' ); ?></label>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_background]" name="simple_gdpr_cookie_compliance_options[color][notice_background]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_background_color ); ?>">
			</p>
			<p>
				<label for="simple_gdpr_cookie_compliance_options[color][notice_text]"><?php _e( 'Notice Text - Color', 'simple-gdpr-cookie-compliance' ); ?></label>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_text]" name="simple_gdpr_cookie_compliance_options[color][notice_text]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_text_color ); ?>">
			</p>
			<p>
				<label for="simple_gdpr_cookie_compliance_options[color][notice_link_color]"><?php _e( 'Notice Link - Color', 'simple-gdpr-cookie-compliance' ); ?></label>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_link_color]" name="simple_gdpr_cookie_compliance_options[color][notice_link_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_link_color ); ?>">
			</p>
			<p>
				<label for="simple_gdpr_cookie_compliance_options[color][notice_link_hover_color]"><?php _e( 'Notice Link - Hover Color', 'simple-gdpr-cookie-compliance' ); ?></label>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_link_hover_color]" name="simple_gdpr_cookie_compliance_options[color][notice_link_hover_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_link_hover_color ); ?>">
			</p>
		</div>
		<?php
	}

	/**
	 * Function for sanitization of fields.
	 *
	 * @since    1.0.0
	 */
	public function sanitize_fields( $inputs ) {

		if ( ! current_user_can( 'manage_options' ) ) {

			return $inputs;
		}

		$allowed_html_tags = array(
			'span' => array(
				'class' => array(),
			),
			'a' => array(
				'class' => array(),
				'href' => array(),
				'target' => array(),
				'title' => array(),
			),
			'i' => array(
				'class' => array(),
			),
		);

		$inputs['notice_text'] = wp_kses( $inputs['notice_text'], $allowed_html_tags );

		$inputs['link']['link_title'] = sanitize_text_field( $inputs['link']['link_title'] );

		$inputs['link']['link_url'] = esc_url_raw( $inputs['link']['link_url'] );

		$inputs['color']['notice_background'] = sanitize_hex_color( $inputs['color']['notice_background'] );

		$inputs['color']['notice_text'] = sanitize_hex_color( $inputs['color']['notice_text'] );

		$inputs['color']['notice_link_color'] = sanitize_hex_color( $inputs['color']['notice_link_color'] );

		$inputs['color']['notice_link_hover_color'] = sanitize_hex_color( $inputs['color']['notice_link_hover_color'] );

		$inputs['cookie_expire_time'] = absint( $inputs['cookie_expire_time'] );

		return $inputs;		
	}
}
