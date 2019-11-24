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

		$notice = ! empty( $this->options['notice_text'] ) ? $this->options['notice_text'] : __( 'Our website uses cookies to make your online experience easier and better. By using our website, you consent to our use of cookies. For more information, read our <a href="https://yourwebsite.com/policy/">cookie policy</a> here.', 'simple-gdpr-cookie-compliance' );
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


		$notice_background_color = ! empty( $this->options['color']['notice_background'] ) ? $this->options['color']['notice_background'] : '#fbf01e';

		$notice_text_color = ! empty( $this->options['color']['notice_text'] ) ? $this->options['color']['notice_text'] : '#222222';

		$notice_link_color = ! empty( $this->options['color']['notice_link_color'] ) ? $this->options['color']['notice_link_color'] : '#222222';

		$notice_link_hover_color = ! empty( $this->options['color']['notice_link_hover_color'] ) ? $this->options['color']['notice_link_hover_color'] : '#4CC500';

		$notice_cookie_icon_color = ! empty( $this->options['color']['notice_cookie_icon_color'] ) ? $this->options['color']['notice_cookie_icon_color'] : '#222222';

		$notice_compliance_button_bg = ! empty( $this->options['color']['notice_compliance_button_bg'] ) ? $this->options['color']['notice_compliance_button_bg'] : '#222222';

		$notice_compliance_button_hover_bg_color = ! empty( $this->options['color']['notice_compliance_button_hover_bg_color'] ) ? $this->options['color']['notice_compliance_button_hover_bg_color'] : '#4cc500';

		$notice_compliance_button_border_color = ! empty( $this->options['color']['notice_compliance_button_border_color'] ) ? $this->options['color']['notice_compliance_button_border_color'] : '#222222';

		$notice_compliance_button_hover_border_color = ! empty( $this->options['color']['notice_compliance_button_hover_border_color'] ) ? $this->options['color']['notice_compliance_button_hover_border_color'] : '#4cc500';

		$notice_compliance_button_text_color = ! empty( $this->options['color']['notice_compliance_button_text_color'] ) ? $this->options['color']['notice_compliance_button_text_color'] : '#ffffff';

		$notice_compliance_button_hover_text_color = ! empty( $this->options['color']['notice_compliance_button_hover_text_color'] ) ? $this->options['color']['notice_compliance_button_hover_text_color'] : '#ffffff';

		$notice_box_close_btn_bg_color = ! empty( $this->options['color']['notice_box_close_btn_bg_color'] ) ? $this->options['color']['notice_box_close_btn_bg_color'] : '#222222';

		$notice_box_close_btn_bg_hover_color = ! empty( $this->options['color']['notice_box_close_btn_bg_hover_color'] ) ? $this->options['color']['notice_box_close_btn_bg_hover_color'] : '#4cc500';

		$notice_box_close_btn_text_color = ! empty( $this->options['color']['notice_box_close_btn_text_color'] ) ? $this->options['color']['notice_box_close_btn_text_color'] : '#ffffff';

		$notice_box_close_btn_hover_text_color = ! empty( $this->options['color']['notice_box_close_btn_hover_text_color'] ) ? $this->options['color']['notice_box_close_btn_hover_text_color'] : '#ffffff';

		?>
		<div class="s_gdpr_c_n_field s_gdpr_c_n_color_options_field" id="s_gdpr_c_n_link">
			<p>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_background]" name="simple_gdpr_cookie_compliance_options[color][notice_background]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_background_color ); ?>">
				<label for="simple_gdpr_cookie_compliance_options[color][notice_background]"><?php _e( 'Notice -  Background Color', 'simple-gdpr-cookie-compliance' ); ?></label>
			</p>
			<p>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_cookie_icon_color]" name="simple_gdpr_cookie_compliance_options[color][notice_cookie_icon_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_cookie_icon_color ); ?>">
				<label for="simple_gdpr_cookie_compliance_options[color][notice_cookie_icon_color]"><?php _e( 'Notice Cookie Icon - Color', 'simple-gdpr-cookie-compliance' ); ?></label>
			</p>
			<p>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_text]" name="simple_gdpr_cookie_compliance_options[color][notice_text]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_text_color ); ?>">
				<label for="simple_gdpr_cookie_compliance_options[color][notice_text]"><?php _e( 'Notice Text - Color', 'simple-gdpr-cookie-compliance' ); ?></label>
			</p>
			<p>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_link_color]" name="simple_gdpr_cookie_compliance_options[color][notice_link_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_link_color ); ?>">
				<label for="simple_gdpr_cookie_compliance_options[color][notice_link_color]"><?php _e( 'Notice Link - Color', 'simple-gdpr-cookie-compliance' ); ?></label>
			</p>
			<p>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_link_hover_color]" name="simple_gdpr_cookie_compliance_options[color][notice_link_hover_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_link_hover_color ); ?>">
				<label for="simple_gdpr_cookie_compliance_options[color][notice_link_hover_color]"><?php _e( 'Notice Link - Hover Color', 'simple-gdpr-cookie-compliance' ); ?></label>
			</p>

			<p>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_bg_color]" name="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_bg_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_box_close_btn_bg_color ); ?>">
				<label for="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_bg_color]"><?php _e( 'Notice Box Close Button - Background Color', 'simple-gdpr-cookie-compliance' ); ?></label>
			</p>

			<p>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_bg_hover_color]" name="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_bg_hover_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_box_close_btn_bg_hover_color ); ?>">
				<label for="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_bg_hover_color]"><?php _e( 'Notice Box Close Button Hover - Background Color', 'simple-gdpr-cookie-compliance' ); ?></label>
			</p>

			<p>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_text_color]" name="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_text_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_box_close_btn_text_color ); ?>">
				<label for="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_text_color]"><?php _e( 'Notice Box Close Button - Text Color', 'simple-gdpr-cookie-compliance' ); ?></label>
			</p>

			<p>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_hover_text_color]" name="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_hover_text_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_box_close_btn_hover_text_color ); ?>">
				<label for="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_hover_text_color]"><?php _e( 'Notice Box Close Button Hover - Text Color', 'simple-gdpr-cookie-compliance' ); ?></label>
			</p>

			<p>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_bg]" name="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_bg]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_compliance_button_bg ); ?>">
				<label for="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_bg]"><?php _e( 'Accept Button - Background Color', 'simple-gdpr-cookie-compliance' ); ?></label>
			</p>

			<p>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_hover_bg_color]" name="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_hover_bg_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_compliance_button_hover_bg_color ); ?>">
				<label for="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_hover_bg_color]"><?php _e( 'Accept Button Hover - Background Color', 'simple-gdpr-cookie-compliance' ); ?></label>
			</p>

			<p>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_border_color]" name="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_border_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_compliance_button_border_color ); ?>">
				<label for="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_border_color]"><?php _e( 'Accept Button - Border Color', 'simple-gdpr-cookie-compliance' ); ?></label>
			</p>

			<p>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_hover_border_color]" name="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_hover_border_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_compliance_button_hover_border_color ); ?>">
				<label for="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_hover_border_color]"><?php _e( 'Accept Button Hover - Border Color', 'simple-gdpr-cookie-compliance' ); ?></label>
			</p>

			<p>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_text_color]" name="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_text_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_compliance_button_text_color ); ?>">
				<label for="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_text_color]"><?php _e( 'Accept Button - Text Color', 'simple-gdpr-cookie-compliance' ); ?></label>
			</p>

			<p>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_hover_text_color]" name="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_hover_text_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_compliance_button_hover_text_color ); ?>">
				<label for="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_hover_text_color]"><?php _e( 'Accept Button Hover -  Text Color', 'simple-gdpr-cookie-compliance' ); ?></label>
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

		$inputs['color']['notice_background'] = sanitize_hex_color( $inputs['color']['notice_background'] );

		$inputs['color']['notice_text'] = sanitize_hex_color( $inputs['color']['notice_text'] );

		$inputs['color']['notice_link_color'] = sanitize_hex_color( $inputs['color']['notice_link_color'] );

		$inputs['color']['notice_link_hover_color'] = sanitize_hex_color( $inputs['color']['notice_link_hover_color'] );

		$inputs['cookie_expire_time'] = absint( $inputs['cookie_expire_time'] );

		return $inputs;		
	}
}
