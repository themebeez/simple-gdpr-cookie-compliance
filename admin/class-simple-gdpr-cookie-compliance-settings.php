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
			__( 'Notice Content', 'simple-gdpr-cookie-compliance' ), 
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

		$notice = isset( $this->options['notice_text'] ) ? $this->options['notice_text'] : __( 'Our website uses cookies to provide you the best experience. However, by continuing to use our website, you agree to our use of cookies. For more information, read our <a href="#">Cookie Policy</a>.', 'simple-gdpr-cookie-compliance' );

		$link_type = isset( $this->options['link']['link_type'] ) ? $this->options['link']['link_type'] : 'no_link';

		$before_link = isset( $this->options['link']['before_link'] ) ? $this->options['link']['before_link'] : '';

		$after_link = isset( $this->options['link']['after_link'] ) ? $this->options['link']['after_link'] : '';

		$page = isset( $this->options['link']['page'] ) ? $this->options['link']['page'] : '';

		$link_title = isset( $this->options['link']['link_title'] ) ? $this->options['link']['link_title'] : __( 'More Information', 'simple-gdpr-cookie-compliance' );

		$link_url = isset( $this->options['link']['link_url'] ) ? $this->options['link']['link_url'] : '#';

		$accept_btn_title = isset( $this->options['accept_btn_title'] ) ? $this->options['accept_btn_title'] : __( 'Accept', 'simple-gdpr-cookie-compliance' );

		$show_in_new_tab = isset( $this->options['show_in_new_tab'] ) ? $this->options['show_in_new_tab'] : true;

		?>
		<div class="s_gdpr_c_n_field" id="s_gdpr_c_n_notice_text">
			<p>
				<label for="simple_gdpr_cookie_compliance_options[notice_text]"><?php _e( 'Message', 'simple-gdpr-cookie-compliance' ); ?></label>
				<br/>
				<small class="description"><?php echo __( 'Enter the notice message. You can also insert &lt;span class=&quot;..&quot;&gt;...&lt;/span&gt;, &lt;a href=&quot;..&quot; target=&quot;..&quot; class=&quot;..&quot; title=&quot;..&quot;&gt;...&lt;/a&gt;, and &lt;i class=&quot;..&quot;&gt;...&lt;/i&gt; HTML tags along with the message.', 'simple-gdpr-cookie-compliance' ); ?></small>
				<textarea id="simple_gdpr_cookie_compliance_options[notice_text]" name="simple_gdpr_cookie_compliance_options[notice_text]" class="s_gdpr_c_n_textarea" cols="50" rows="5"><?php echo wp_kses_post( $notice ); ?></textarea>				
			</p>

			<p>
				<label for="simple_gdpr_cookie_compliance_options['link']['link_type']"><?php _e( 'Link Type', 'simple-gdpr-cookie-compliance' ); ?></label>
				<?php
				$link_types = array(
					'no_link' => __( 'No Link', 'simple-gdpr-cookie-compliance' ),
					'custom_url' => __( 'Custom Link', 'simple-gdpr-cookie-compliance' ),
					'page' => __( 'Page', 'simple-gdpr-cookie-compliance' )
				);
				?>
				<select class="sgdpr_link_type" name="simple_gdpr_cookie_compliance_options[link][link_type]" id="simple_gdpr_cookie_compliance_options[link][link_type]">
					<?php
					foreach( $link_types as $key => $value ) {
						?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $link_type ); ?>><?php echo esc_html( $value ); ?></option>
						<?php
					}
					?>
				</select>
			</p>

			<div class="s_gdpr_c_n_field_link_content_wrapper <?php echo ( $link_type == 'no_link' ) ? 'sgdpr_hidden' : ''; ?>">
				
				<h3><?php echo __( 'Link Content', 'simple-gdpr-cookie-compliance' ); ?></h3>
				<p><small><?php echo __( 'Link content will be appended after the message.', 'simple-gdpr-cookie-compliance' ); ?></small></p>

				<p>
					<label for="simple_gdpr_cookie_compliance_options[link][before_link]"><?php _e( 'Text Before Link', 'simple-gdpr-cookie-compliance' ); ?></label>
					<input type="text" id="simple_gdpr_cookie_compliance_options[link][before_link]" name="simple_gdpr_cookie_compliance_options[link][before_link]" class="s_gdpr_c_c_text" value="<?php echo esc_attr( $before_link ); ?>">
				</p>

				<p>
					<label for="simple_gdpr_cookie_compliance_options[link][after_link]"><?php _e( 'Text After Link', 'simple-gdpr-cookie-compliance' ); ?></label>
					<input type="text" id="simple_gdpr_cookie_compliance_options[link][after_link]" name="simple_gdpr_cookie_compliance_options[link][after_link]" class="s_gdpr_c_c_text" value="<?php echo esc_attr( $after_link ); ?>">
				</p>
	
				<div class="s_gdpr_c_n_field_custom_link_wrapper <?php echo ( $link_type == 'custom_url' ) ? '' : 'sgdpr_hidden'; ?>">
					<p>
						<label for="simple_gdpr_cookie_compliance_options[link][link_title]"><?php _e( 'Custom Link Title', 'simple-gdpr-cookie-compliance' ); ?></label>
						<input type="text" id="simple_gdpr_cookie_compliance_options[link][link_title]" name="simple_gdpr_cookie_compliance_options[link][link_title]" class="s_gdpr_c_c_text" value="<?php echo esc_attr( $link_title ); ?>">
					</p>

					<p>
						<label for="simple_gdpr_cookie_compliance_options[link][link_url]"><?php _e( 'Custom URL', 'simple-gdpr-cookie-compliance' ); ?></label>
						<input type="text" id="simple_gdpr_cookie_compliance_options[link][link_url]" name="simple_gdpr_cookie_compliance_options[link][link_url]" class="s_gdpr_c_c_text" value="<?php echo esc_attr( $link_url ); ?>">
					</p>
				</div>

				<div class="s_gdpr_c_n_field_page_selection_wrapper <?php echo ( $link_type == 'page' ) ? '' : 'sgdpr_hidden'; ?>">
					<p>
						<label for="simple_gdpr_cookie_compliance_options[link][page]"><?php _e( 'Link Page', 'simple-gdpr-cookie-compliance' ); ?></label>
						<?php
						wp_dropdown_pages( array(
		                    'id'               => 'simple_gdpr_cookie_compliance_options[link][page]',
		                    'class'            => 's_gdpr_c_c_text',
		                    'name'             => 'simple_gdpr_cookie_compliance_options[link][page]',
		                    'selected'         => esc_attr( $page ),
		                    'show_option_none' => __( 'Select Page', 'simple-gdpr-cookie-compliance' ),
		                    )
		                );
						?>
					</p>
				</div>

				<p>
					
					<input type="checkbox" id="simple_gdpr_cookie_compliance_options[show_in_new_tab]" name="simple_gdpr_cookie_compliance_options[show_in_new_tab]" class="s_gdpr_c_c_text" value="1" <?php checked( 1, absint( $show_in_new_tab ) ); ?>>
					<label for="simple_gdpr_cookie_compliance_options[show_in_new_tab]"><?php _e( 'Show link in a new tab', 'simple-gdpr-cookie-compliance' ); ?></label>
				</p>
			</div>

			<p>
				<label for="simple_gdpr_cookie_compliance_options[accept_btn_title]"><?php _e( 'Accept Button Title', 'simple-gdpr-cookie-compliance' ); ?></label>
				<input type="text" id="simple_gdpr_cookie_compliance_options[accept_btn_title]" name="simple_gdpr_cookie_compliance_options[accept_btn_title]" class="s_gdpr_c_c_text" value="<?php echo esc_attr( $accept_btn_title ); ?>">
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

		$cookie_expire_time = ! empty( $this->options['cookie_expire_time'] ) ? $this->options['cookie_expire_time'] : 0;
		?>
		<div class="s_gdpr_c_n_field" id="s_gdpr_c_n_cookie">
			<p>
				<label for="simple_gdpr_cookie_compliance_options[cookie_expire_time]"><?php echo __( 'Cookie Expire Time', 'simple-gdpr-cookie-compliance' ); ?></label>
				<input type="number" id="simple_gdpr_cookie_compliance_options[cookie_expire_time]" name="simple_gdpr_cookie_compliance_options[cookie_expire_time]" class="s_gdpr_c_n_number" value="<?php echo esc_attr( $cookie_expire_time ); ?>">
				<small><?php echo __( 'Once the user clicks on Accept button, cookie notice will disappear. Expire Time sets the time duration for which cookie notice will disappear. Set &quot;0&quot; for SESSION cookie.', 'simple-gdpr-cookie-compliance' ); ?></small>
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
				<label for="simple_gdpr_cookie_compliance_options[color][notice_background]"><?php _e( 'Notice Background Color', 'simple-gdpr-cookie-compliance' ); ?></label>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_background]" name="simple_gdpr_cookie_compliance_options[color][notice_background]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_background_color ); ?>">
			</p>
			<p>
				<label for="simple_gdpr_cookie_compliance_options[color][notice_cookie_icon_color]"><?php _e( 'Cookie Icon - Color', 'simple-gdpr-cookie-compliance' ); ?></label>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_cookie_icon_color]" name="simple_gdpr_cookie_compliance_options[color][notice_cookie_icon_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_cookie_icon_color ); ?>">				
			</p>
			<p>
				<label for="simple_gdpr_cookie_compliance_options[color][notice_text]"><?php _e( 'Notice Text Color', 'simple-gdpr-cookie-compliance' ); ?></label>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_text]" name="simple_gdpr_cookie_compliance_options[color][notice_text]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_text_color ); ?>">				
			</p>
			<p>
				<label for="simple_gdpr_cookie_compliance_options[color][notice_link_color]"><?php _e( 'Notice Link Color', 'simple-gdpr-cookie-compliance' ); ?></label>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_link_color]" name="simple_gdpr_cookie_compliance_options[color][notice_link_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_link_color ); ?>">				
			</p>
			<p>
				<label for="simple_gdpr_cookie_compliance_options[color][notice_link_hover_color]"><?php _e( 'Notice Link Color - On Hover', 'simple-gdpr-cookie-compliance' ); ?></label>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_link_hover_color]" name="simple_gdpr_cookie_compliance_options[color][notice_link_hover_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_link_hover_color ); ?>">				
			</p>

			<p>
				<label for="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_bg_color]"><?php _e( 'Close Button Background Color', 'simple-gdpr-cookie-compliance' ); ?></label>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_bg_color]" name="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_bg_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_box_close_btn_bg_color ); ?>">				
			</p>

			<p>
				<label for="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_bg_hover_color]"><?php _e( 'Close Button Background Color - On Hover', 'simple-gdpr-cookie-compliance' ); ?></label>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_bg_hover_color]" name="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_bg_hover_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_box_close_btn_bg_hover_color ); ?>">				
			</p>

			<p>
				<label for="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_text_color]"><?php _e( 'Close Button Text Color', 'simple-gdpr-cookie-compliance' ); ?></label>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_text_color]" name="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_text_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_box_close_btn_text_color ); ?>">				
			</p>

			<p>
				<label for="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_hover_text_color]"><?php _e( 'Close Button Text Color - On Hover', 'simple-gdpr-cookie-compliance' ); ?></label>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_hover_text_color]" name="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_hover_text_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_box_close_btn_hover_text_color ); ?>">				
			</p>

			<p>
				<label for="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_bg]"><?php _e( 'Accept Button Background Color', 'simple-gdpr-cookie-compliance' ); ?></label>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_bg]" name="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_bg]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_compliance_button_bg ); ?>">				
			</p>

			<p>
				<label for="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_hover_bg_color]"><?php _e( 'Accept Button Background Color - On Hover', 'simple-gdpr-cookie-compliance' ); ?></label>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_hover_bg_color]" name="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_hover_bg_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_compliance_button_hover_bg_color ); ?>">				
			</p>

			<p>
				<label for="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_border_color]"><?php _e( 'Accept Button Border Color', 'simple-gdpr-cookie-compliance' ); ?></label>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_border_color]" name="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_border_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_compliance_button_border_color ); ?>">				
			</p>

			<p>
				<label for="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_hover_border_color]"><?php _e( 'Accept Button Border Color - On Hover', 'simple-gdpr-cookie-compliance' ); ?></label>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_hover_border_color]" name="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_hover_border_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_compliance_button_hover_border_color ); ?>">				
			</p>

			<p>
				<label for="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_text_color]"><?php _e( 'Accept Button Text Color', 'simple-gdpr-cookie-compliance' ); ?></label>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_text_color]" name="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_text_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_compliance_button_text_color ); ?>">				
			</p>

			<p>
				<label for="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_hover_text_color]"><?php _e( 'Accept Button Text Color - On Hover', 'simple-gdpr-cookie-compliance' ); ?></label>
				<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_hover_text_color]" name="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_hover_text_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_compliance_button_hover_text_color ); ?>">				
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

		$inputs['link']['link_type'] = sanitize_text_field( $inputs['link']['link_type'] );

		$inputs['link']['before_link'] = sanitize_text_field( $inputs['link']['before_link'] );

		$inputs['link']['after_link'] = sanitize_text_field( $inputs['link']['after_link'] );

		$inputs['link']['link_title'] = sanitize_text_field( $inputs['link']['link_title'] );

		$inputs['link']['link_url'] = esc_url_raw( $inputs['link']['link_url'] );

		$inputs['link']['page'] = sanitize_text_field( $inputs['link']['page'] );

		$inputs['show_in_new_tab'] = isset( $inputs['show_in_new_tab'] ) ? wp_validate_boolean( $inputs['show_in_new_tab'] ) : false;

		$inputs['accept_btn_title'] = sanitize_text_field( $inputs['accept_btn_title'] );

		$inputs['color']['notice_background'] = sanitize_hex_color( $inputs['color']['notice_background'] );

		$inputs['color']['notice_text'] = sanitize_hex_color( $inputs['color']['notice_text'] );

		$inputs['color']['notice_link_color'] = sanitize_hex_color( $inputs['color']['notice_link_color'] );

		$inputs['color']['notice_link_hover_color'] = sanitize_hex_color( $inputs['color']['notice_link_hover_color'] );

		$inputs['color']['notice_cookie_icon_color'] = sanitize_hex_color( $inputs['color']['notice_cookie_icon_color'] );

		$inputs['color']['notice_compliance_button_bg'] = sanitize_hex_color( $inputs['color']['notice_compliance_button_bg'] );

		$inputs['color']['notice_compliance_button_hover_bg_color'] = sanitize_hex_color( $inputs['color']['notice_compliance_button_hover_bg_color'] );

		$inputs['color']['notice_compliance_button_border_color'] = sanitize_hex_color( $inputs['color']['notice_compliance_button_border_color'] );

		$inputs['color']['notice_compliance_button_hover_border_color'] = sanitize_hex_color( $inputs['color']['notice_compliance_button_hover_border_color'] );

		$inputs['color']['notice_compliance_button_text_color'] = sanitize_hex_color( $inputs['color']['notice_compliance_button_text_color'] );

		$inputs['color']['notice_compliance_button_hover_text_color'] = sanitize_hex_color( $inputs['color']['notice_compliance_button_hover_text_color'] );

		$inputs['color']['notice_box_close_btn_bg_color'] = sanitize_hex_color( $inputs['color']['notice_box_close_btn_bg_color'] );

		$inputs['color']['notice_box_close_btn_bg_hover_color'] = sanitize_hex_color( $inputs['color']['notice_box_close_btn_bg_hover_color'] );

		$inputs['color']['notice_box_close_btn_text_color'] = sanitize_hex_color( $inputs['color']['notice_box_close_btn_text_color'] );

		$inputs['color']['notice_box_close_btn_hover_text_color'] = sanitize_hex_color( $inputs['color']['notice_box_close_btn_hover_text_color'] );

		$inputs['cookie_expire_time'] = absint( $inputs['cookie_expire_time'] );

		return $inputs;		
	}
}
