<?php
/**
 * The admin-settings functionality of the plugin.
 *
 * @package    Simple_GDPR_Cookie_Compliance
 * @subpackage Simple_GDPR_Cookie_Compliance/admin
 * @author     themebeez <themebeez@gmail.com>
 */

/**
 * Class that defines the admin-settings functionality of the plugin.
 *
 * @package    Simple_GDPR_Cookie_Compliance
 * @subpackage Simple_GDPR_Cookie_Compliance/admin
 * @author     themebeez <themebeez@gmail.com>
 */
class Simple_GDPR_Cookie_Compliance_Settings {

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
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		if ( get_option( 'simple_gdpr_cookie_compliance_options' ) ) {

			$this->options = get_option( 'simple_gdpr_cookie_compliance_options' );
		}
	}

	/**
	 * Register register settings.
	 *
	 * @since    1.0.0
	 */
	public function register_settings() {

		register_setting(
			'simple_gdpr_cookie_compliance_settings', // Option Group ID.
			'simple_gdpr_cookie_compliance_options', // Settings ID.
			array( $this, 'sanitize_fields' ) // Sanitization Callback.
		);

		add_settings_section(
			'simple_gdpr_cookie_compliance_fields_section', // Section ID.
			__( 'Configure Settings', 'simple-gdpr-cookie-compliance' ), // Section Title.
			array( $this, 'section_callback' ), // Section Callback.
			'simple_gdpr_cookie_compliance_settings' // Option Group ID.
		);

		add_settings_field(
			's_gdpr_c_n_notice_text',
			__( 'Notice Content', 'simple-gdpr-cookie-compliance' ),
			array( $this, 'notice_field' ),
			'simple_gdpr_cookie_compliance_settings',
			'simple_gdpr_cookie_compliance_fields_section'
		);

		add_settings_field(
			's_gdpr_c_n_cookie',
			__( 'Cookie', 'simple-gdpr-cookie-compliance' ),
			array( $this, 'cookie_fields' ),
			'simple_gdpr_cookie_compliance_settings',
			'simple_gdpr_cookie_compliance_fields_section'
		);

		add_settings_field(
			's_gdpr_c_n_styles',
			__( 'Style', 'simple-gdpr-cookie-compliance' ),
			array( $this, 'style_fields' ),
			'simple_gdpr_cookie_compliance_settings',
			'simple_gdpr_cookie_compliance_fields_section'
		);

		add_settings_field(
			's_gdpr_c_n_colors',
			__( 'Colors', 'simple-gdpr-cookie-compliance' ),
			array( $this, 'color_fields' ),
			'simple_gdpr_cookie_compliance_settings',
			'simple_gdpr_cookie_compliance_fields_section'
		);

		add_settings_field(
			's_gdpr_c_n_custom_css',
			__( 'Custom CSS', 'simple-gdpr-cookie-compliance' ),
			array( $this, 'custom_css_fields' ),
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

		$show_close_btn = isset( $this->options['show_close_btn'] ) ? $this->options['show_close_btn'] : true;

		$show_cookie_icon = isset( $this->options['show_cookie_icon'] ) ? $this->options['show_cookie_icon'] : true;

		?>
		<div class="s_gdpr_c_n_field" id="s_gdpr_c_n_notice_text">
			<p>
				<label for="simple_gdpr_cookie_compliance_options[notice_text]">
					<?php esc_html_e( 'Message', 'simple-gdpr-cookie-compliance' ); ?>
				</label>
				<br/>
				<small class="description">
					<?php echo esc_html__( 'Enter the notice message. You can also insert &lt;span class=&quot;..&quot;&gt;...&lt;/span&gt;, &lt;a href=&quot;..&quot; target=&quot;..&quot; class=&quot;..&quot; title=&quot;..&quot;&gt;...&lt;/a&gt;, and &lt;i class=&quot;..&quot;&gt;...&lt;/i&gt; HTML tags along with the message.', 'simple-gdpr-cookie-compliance' ); ?>
				</small>
				<textarea id="simple_gdpr_cookie_compliance_options[notice_text]" name="simple_gdpr_cookie_compliance_options[notice_text]" class="s_gdpr_c_n_textarea" cols="50" rows="5"><?php echo wp_kses_post( $notice ); ?></textarea>				
			</p>

			<p>
				<label for="simple_gdpr_cookie_compliance_options['link']['link_type']"><?php esc_html_e( 'Link Type', 'simple-gdpr-cookie-compliance' ); ?></label>
				<?php
				$link_types = array(
					'no_link'    => esc_html__( 'No Link', 'simple-gdpr-cookie-compliance' ),
					'custom_url' => esc_html__( 'Custom Link', 'simple-gdpr-cookie-compliance' ),
					'page'       => esc_html__( 'Page', 'simple-gdpr-cookie-compliance' ),
				);
				?>
				<select class="sgdpr_link_type" name="simple_gdpr_cookie_compliance_options[link][link_type]" id="simple_gdpr_cookie_compliance_options[link][link_type]">
					<?php
					foreach ( $link_types as $key => $value ) {
						?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $link_type ); ?>>
							<?php echo esc_html( $value ); ?>
						</option>
						<?php
					}
					?>
				</select>
			</p>

			<div class="s_gdpr_c_n_field_link_content_wrapper <?php echo ( 'no_link' === $link_type ) ? 'sgdpr_hidden' : ''; ?>">
				<h3><?php echo esc_html__( 'Link Content', 'simple-gdpr-cookie-compliance' ); ?></h3>
				<p><small><?php echo esc_html__( 'Link content will be appended after the message.', 'simple-gdpr-cookie-compliance' ); ?></small></p>

				<p>
					<label for="simple_gdpr_cookie_compliance_options[link][before_link]"><?php esc_html_e( 'Text Before Link', 'simple-gdpr-cookie-compliance' ); ?></label>
					<input type="text" id="simple_gdpr_cookie_compliance_options[link][before_link]" name="simple_gdpr_cookie_compliance_options[link][before_link]" class="s_gdpr_c_c_text" value="<?php echo esc_attr( $before_link ); ?>">
				</p>

				<p>
					<label for="simple_gdpr_cookie_compliance_options[link][after_link]"><?php esc_html_e( 'Text After Link', 'simple-gdpr-cookie-compliance' ); ?></label>
					<input type="text" id="simple_gdpr_cookie_compliance_options[link][after_link]" name="simple_gdpr_cookie_compliance_options[link][after_link]" class="s_gdpr_c_c_text" value="<?php echo esc_attr( $after_link ); ?>">
				</p>

				<div class="s_gdpr_c_n_field_custom_link_wrapper <?php echo ( 'custom_url' === $link_type ) ? '' : 'sgdpr_hidden'; ?>">
					<p>
						<label for="simple_gdpr_cookie_compliance_options[link][link_title]"><?php esc_html_e( 'Custom Link Title', 'simple-gdpr-cookie-compliance' ); ?></label>
						<input type="text" id="simple_gdpr_cookie_compliance_options[link][link_title]" name="simple_gdpr_cookie_compliance_options[link][link_title]" class="s_gdpr_c_c_text" value="<?php echo esc_attr( $link_title ); ?>">
					</p>

					<p>
						<label for="simple_gdpr_cookie_compliance_options[link][link_url]"><?php esc_html_e( 'Custom URL', 'simple-gdpr-cookie-compliance' ); ?></label>
						<input type="text" id="simple_gdpr_cookie_compliance_options[link][link_url]" name="simple_gdpr_cookie_compliance_options[link][link_url]" class="s_gdpr_c_c_text" value="<?php echo esc_attr( $link_url ); ?>">
					</p>
				</div>

				<div class="s_gdpr_c_n_field_page_selection_wrapper <?php echo ( 'page' === $link_type ) ? '' : 'sgdpr_hidden'; ?>">
					<p>
						<label for="simple_gdpr_cookie_compliance_options[link][page]"><?php esc_html_e( 'Link Page', 'simple-gdpr-cookie-compliance' ); ?></label>
						<?php
						wp_dropdown_pages(
							array(
								'id'               => 'simple_gdpr_cookie_compliance_options[link][page]',
								'class'            => 's_gdpr_c_c_text',
								'name'             => 'simple_gdpr_cookie_compliance_options[link][page]',
								'selected'         => esc_attr( $page ),
								'show_option_none' => esc_html__( 'Select Page', 'simple-gdpr-cookie-compliance' ),
							)
						);
						?>
					</p>
				</div>

				<p>
					<label for="simple_gdpr_cookie_compliance_options[show_in_new_tab]"><input type="checkbox" id="simple_gdpr_cookie_compliance_options[show_in_new_tab]" name="simple_gdpr_cookie_compliance_options[show_in_new_tab]" class="s_gdpr_c_c_text" value="1" <?php checked( 1, absint( $show_in_new_tab ) ); ?>><?php esc_html_e( 'Show link in a new tab', 'simple-gdpr-cookie-compliance' ); ?></label>
				</p>
			</div>

			<p>
				<label for="simple_gdpr_cookie_compliance_options[accept_btn_title]"><?php esc_html_e( 'Accept Button Title', 'simple-gdpr-cookie-compliance' ); ?></label>
				<input type="text" id="simple_gdpr_cookie_compliance_options[accept_btn_title]" name="simple_gdpr_cookie_compliance_options[accept_btn_title]" class="s_gdpr_c_c_text" value="<?php echo esc_attr( $accept_btn_title ); ?>">
			</p>

			<p>
				<label for="simple_gdpr_cookie_compliance_options[show_close_btn]"><input type="checkbox" id="simple_gdpr_cookie_compliance_options[show_close_btn]" name="simple_gdpr_cookie_compliance_options[show_close_btn]" class="s_gdpr_c_c_text" <?php checked( $show_close_btn, true ); ?>><?php esc_html_e( 'Display Close Button', 'simple-gdpr-cookie-compliance' ); ?></label>				
			</p>

			<p>
				<label for="simple_gdpr_cookie_compliance_options[show_cookie_icon]"><input type="checkbox" id="simple_gdpr_cookie_compliance_options[show_cookie_icon]" name="simple_gdpr_cookie_compliance_options[show_cookie_icon]" class="s_gdpr_c_c_text" <?php checked( $show_cookie_icon, true ); ?>><?php esc_html_e( 'Display Cookie Icon', 'simple-gdpr-cookie-compliance' ); ?></label>				
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
				<label for="simple_gdpr_cookie_compliance_options[cookie_expire_time]"><?php echo esc_html__( 'Cookie Expire Time', 'simple-gdpr-cookie-compliance' ); ?></label>
				<input type="number" id="simple_gdpr_cookie_compliance_options[cookie_expire_time]" name="simple_gdpr_cookie_compliance_options[cookie_expire_time]" class="s_gdpr_c_n_number" value="<?php echo esc_attr( $cookie_expire_time ); ?>">
				<small><?php echo esc_html__( 'Once the user clicks on Accept button, cookie notice will disappear. Expire Time sets the time duration for which cookie notice will disappear. Set &quot;0&quot; for SESSION cookie.', 'simple-gdpr-cookie-compliance' ); ?></small>
			</p>
		<?php
	}

	/**
	 * Style setting fields.
	 *
	 * @since    1.0.4
	 */
	public function style_fields() {

		$type = isset( $this->options['style']['type'] ) ? $this->options['style']['type'] : 'custom_width';

		$width = isset( $this->options['style']['width'] ) ? $this->options['style']['width'] : 450;

		$fullwidth_position = isset( $this->options['style']['fullwidth_position'] ) ? $this->options['style']['fullwidth_position'] : 'top';

		$customwidth_position = isset( $this->options['style']['customwidth_position'] ) ? $this->options['style']['customwidth_position'] : 'bottom_right';

		$enable_bg_overlay = isset( $this->options['style']['enable_bg_overlay'] ) ? $this->options['style']['enable_bg_overlay'] : true;

		$top_offset = isset( $this->options['style']['top_offset'] ) ? $this->options['style']['top_offset'] : 30;

		$left_offset = isset( $this->options['style']['left_offset'] ) ? $this->options['style']['left_offset'] : 30;

		$bottom_offset = isset( $this->options['style']['bottom_offset'] ) ? $this->options['style']['bottom_offset'] : 30;

		$right_offset = isset( $this->options['style']['right_offset'] ) ? $this->options['style']['right_offset'] : 30;
		?>
		<div class="s_gdpr_c_n_field" id="s_gdpr_c_n_style">
			<p>
				<label for="simple_gdpr_cookie_compliance_options[style][type]"><?php echo esc_html__( 'Width Style', 'simple-gdpr-cookie-compliance' ); ?></label>
				<?php
				$styles = array(
					'full_width'   => esc_html__( 'Full Width', 'simple-gdpr-cookie-compliance' ),
					'custom_width' => esc_html__( 'Custom Width', 'simple-gdpr-cookie-compliance' ),
					'pop_up'       => esc_html__( 'Pop Up', 'simple-gdpr-cookie-compliance' ),
				);
				?>
				<select class="sgdpr_notice_type" name="simple_gdpr_cookie_compliance_options[style][type]" id="simple_gdpr_cookie_compliance_options[style][type]">
					<?php
					foreach ( $styles as $key => $value ) {
						?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $type ); ?>><?php echo esc_html( $value ); ?></option>
						<?php
					}
					?>
				</select>
			</p>

			<p id="s_gdpr_c_n_width" class="<?php echo ( 'full_width' === $type ) ? 'sgdpr_hidden' : ''; ?>">
				<label for="simple_gdpr_cookie_compliance_options[style][width]"><?php echo esc_html__( 'Width', 'simple-gdpr-cookie-compliance' ); ?></label>
				<input type="number" id="simple_gdpr_cookie_compliance_options[style][width]" name="simple_gdpr_cookie_compliance_options[style][width]" class="s_gdpr_c_n_number" value="<?php echo esc_attr( $width ); ?>">
			</p>

			<p id="s_gdpr_c_n_fullwidth_position" class="<?php echo ( 'full_width' === $type ) ? '' : 'sgdpr_hidden'; ?>">
				<label for="simple_gdpr_cookie_compliance_options[style][fullwidth_position]"><?php echo esc_html__( 'Position', 'simple-gdpr-cookie-compliance' ); ?></label>
				<?php
				$styles = array(
					'top'    => esc_html__( 'Top', 'simple-gdpr-cookie-compliance' ),
					'bottom' => esc_html__( 'Bottom', 'simple-gdpr-cookie-compliance' ),
				);
				?>
				<select class="sgdpr_position" name="simple_gdpr_cookie_compliance_options[style][fullwidth_position]" id="simple_gdpr_cookie_compliance_options[style][fullwidth_position]">
					<?php
					foreach ( $styles as $key => $value ) {
						?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $fullwidth_position ); ?>><?php echo esc_html( $value ); ?></option>
						<?php
					}
					?>
				</select>
			</p>

			<p id="s_gdpr_c_n_customwidth_position" class="<?php echo ( 'custom_width' !== $type ) ? 'sgdpr_hidden' : ''; ?>">
				<label for="simple_gdpr_cookie_compliance_options[style][customwidth_position]"><?php echo esc_html__( 'Position', 'simple-gdpr-cookie-compliance' ); ?></label>
				<?php
				$styles = array(
					'top_left'      => esc_html__( 'Top Left', 'simple-gdpr-cookie-compliance' ),
					'top_center'    => esc_html__( 'Top Center', 'simple-gdpr-cookie-compliance' ),
					'top_right'     => esc_html__( 'Top Right', 'simple-gdpr-cookie-compliance' ),
					'bottom_left'   => esc_html__( 'Bottom Left', 'simple-gdpr-cookie-compliance' ),
					'bottom_center' => esc_html__( 'Bottom Center', 'simple-gdpr-cookie-compliance' ),
					'bottom_right'  => esc_html__( 'Bottom Right', 'simple-gdpr-cookie-compliance' ),
				);
				?>
				<select class="sgdpr_customwidth_position" name="simple_gdpr_cookie_compliance_options[style][customwidth_position]" id="simple_gdpr_cookie_compliance_options[style][customwidth_position]">
					<?php
					foreach ( $styles as $key => $value ) {
						?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $customwidth_position ); ?>><?php echo esc_html( $value ); ?></option>
						<?php
					}
					?>
				</select>
			</p>
			<p id="s_gdpr_c_n_enable_bg_overlay" class="s_gdpr_c_n_checkbox_field <?php echo ( 'pop_up' !== $type ) ? 'sgdpr_hidden' : ''; ?>">
				<label for="simple_gdpr_cookie_compliance_options[style][enable_bg_overlay]"><input type="checkbox" class="s_gdpr_c_n_bg_overlay_field" name="simple_gdpr_cookie_compliance_options[style][enable_bg_overlay]" id="simple_gdpr_cookie_compliance_options[style][enable_bg_overlay]" <?php checked( true, $enable_bg_overlay ); ?>><?php echo esc_html__( 'Enable Background Overlay', 'simple-gdpr-cookie-compliance' ); ?></label>

			</p>

			<div id="s_gdpr_c_n_offset_group_wrapper" class="s_gdpr_c_n_group_wrapper <?php echo ( 'custom_width' !== $type ) ? 'sgdpr_hidden' : ''; ?>">
				<h4 class="s_grpd_c_n_group_title"><?php echo esc_html__( 'Offsets', 'simple-gdpr-cookie-compliance' ); ?></h4>
				<div class="s_gdpr_c_n_group s_gdpr_c_n_group-4">
					<div class="s_gdpr_c_n_group_field" id="s_gdpr_c_n_top_offset_group_field">
						<label for="simple_gdpr_cookie_compliance_options[style][top_offset]"><?php echo esc_html__( 'Top (px)', 'simple-gdpr-cookie-compliance' ); ?></label>
						<input type="number" id="simple_gdpr_cookie_compliance_options[style][top_offset]" name="simple_gdpr_cookie_compliance_options[style][top_offset]" class="s_gdpr_c_n_number" value="<?php echo esc_attr( $top_offset ); ?>">
					</div>
					<div class="s_gdpr_c_n_group_field" id="s_gdpr_c_n_right_offset_group_field">
						<label for="simple_gdpr_cookie_compliance_options[style][right_offset]"><?php echo esc_html__( 'Right (px)', 'simple-gdpr-cookie-compliance' ); ?></label>
						<input type="number" id="simple_gdpr_cookie_compliance_options[style][right_offset]" name="simple_gdpr_cookie_compliance_options[style][right_offset]" class="s_gdpr_c_n_number" value="<?php echo esc_attr( $right_offset ); ?>">
					</div>					
					<div class="s_gdpr_c_n_group_field" id="s_gdpr_c_n_bottom_offset_group_field">
						<label for="simple_gdpr_cookie_compliance_options[style][bottom_offset]"><?php echo esc_html__( 'Bottom (px)', 'simple-gdpr-cookie-compliance' ); ?></label>
						<input type="number" id="simple_gdpr_cookie_compliance_options[style][bottom_offset]" name="simple_gdpr_cookie_compliance_options[style][bottom_offset]" class="s_gdpr_c_n_number" value="<?php echo esc_attr( $bottom_offset ); ?>">
					</div>
					<div class="s_gdpr_c_n_group_field" id="s_gdpr_c_n_left_offset_group_field">
						<label for="simple_gdpr_cookie_compliance_options[style][left_offset]"><?php echo esc_html__( 'Left (px)', 'simple-gdpr-cookie-compliance' ); ?></label>
						<input type="number" id="simple_gdpr_cookie_compliance_options[style][left_offset]" name="simple_gdpr_cookie_compliance_options[style][left_offset]" class="s_gdpr_c_n_number" value="<?php echo esc_attr( $left_offset ); ?>">
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Color setting fields.
	 *
	 * @since    1.0.0
	 */
	public function color_fields() {

		$notice_background_color = isset( $this->options['color']['notice_background'] ) ? $this->options['color']['notice_background'] : '#fbf01e';

		$notice_text_color = isset( $this->options['color']['notice_text'] ) ? $this->options['color']['notice_text'] : '#222222';

		$notice_link_color = isset( $this->options['color']['notice_link_color'] ) ? $this->options['color']['notice_link_color'] : '#222222';

		$notice_link_hover_color = isset( $this->options['color']['notice_link_hover_color'] ) ? $this->options['color']['notice_link_hover_color'] : '#4CC500';

		$notice_cookie_icon_color = isset( $this->options['color']['notice_cookie_icon_color'] ) ? $this->options['color']['notice_cookie_icon_color'] : '#222222';

		$notice_compliance_button_bg = isset( $this->options['color']['notice_compliance_button_bg'] ) ? $this->options['color']['notice_compliance_button_bg'] : '#222222';

		$notice_compliance_button_hover_bg_color = isset( $this->options['color']['notice_compliance_button_hover_bg_color'] ) ? $this->options['color']['notice_compliance_button_hover_bg_color'] : '#4cc500';

		$notice_compliance_button_border_color = isset( $this->options['color']['notice_compliance_button_border_color'] ) ? $this->options['color']['notice_compliance_button_border_color'] : '#222222';

		$notice_compliance_button_hover_border_color = isset( $this->options['color']['notice_compliance_button_hover_border_color'] ) ? $this->options['color']['notice_compliance_button_hover_border_color'] : '#4cc500';

		$notice_compliance_button_text_color = isset( $this->options['color']['notice_compliance_button_text_color'] ) ? $this->options['color']['notice_compliance_button_text_color'] : '#ffffff';

		$notice_compliance_button_hover_text_color = isset( $this->options['color']['notice_compliance_button_hover_text_color'] ) ? $this->options['color']['notice_compliance_button_hover_text_color'] : '#ffffff';

		$notice_box_close_btn_bg_color = isset( $this->options['color']['notice_box_close_btn_bg_color'] ) ? $this->options['color']['notice_box_close_btn_bg_color'] : '#222222';

		$notice_box_close_btn_bg_hover_color = isset( $this->options['color']['notice_box_close_btn_bg_hover_color'] ) ? $this->options['color']['notice_box_close_btn_bg_hover_color'] : '#4cc500';

		$notice_box_close_btn_text_color = isset( $this->options['color']['notice_box_close_btn_text_color'] ) ? $this->options['color']['notice_box_close_btn_text_color'] : '#ffffff';

		$notice_box_close_btn_hover_text_color = isset( $this->options['color']['notice_box_close_btn_hover_text_color'] ) ? $this->options['color']['notice_box_close_btn_hover_text_color'] : '#ffffff';

		$notice_bg_overlay_color = isset( $this->options['color']['notice_bg_overlay_color'] ) ? $this->options['color']['notice_bg_overlay_color'] : 'rgba(0,0,0,0.8)';

		$enable_bg_overlay = isset( $this->options['style']['enable_bg_overlay'] ) ? $this->options['style']['enable_bg_overlay'] : true;

		$type = isset( $this->options['style']['type'] ) ? $this->options['style']['type'] : 'custom_width';

		?>
		<div class="s_gdpr_c_n_field s_gdpr_c_n_color_options_field" id="s_gdpr_c_n_link">

			<div class="s_gdpr_c_n_group_wrapper <?php echo ( true === $enable_bg_overlay && 'pop_up' === $type ) ? '' : 'sgdpr_hidden'; ?>" id="s_gdpr_c_n_bg_overlay">
				<h4 class="s_grpd_c_n_group_title"><?php echo esc_html__( 'Overlay Color', 'simple-gdpr-cookie-compliance' ); ?></h4>
				<div class="s_gdpr_c_n_group">
					<div class="s_gdpr_c_n_group_field">
						<label for="simple_gdpr_cookie_compliance_options[color][notice_bg_overlay_color]"><?php echo esc_html__( 'Background', 'simple-gdpr-cookie-compliance' ); ?></label>
						<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_bg_overlay_color]" name="simple_gdpr_cookie_compliance_options[color][notice_bg_overlay_color]" class="s_gdpr_c_n_color" data-alpha-enabled="true" value="<?php echo esc_attr( $notice_bg_overlay_color ); ?>">
					</div>
				</div>
			</div>

			<div class="s_gdpr_c_n_group_wrapper">
				<h4 class="s_grpd_c_n_group_title"><?php echo esc_html__( 'Notice Color', 'simple-gdpr-cookie-compliance' ); ?></h4>
				<div class="s_gdpr_c_n_group">
					<div class="s_gdpr_c_n_group_field">
						<label for="simple_gdpr_cookie_compliance_options[color][notice_background]"><?php echo esc_html__( 'Background', 'simple-gdpr-cookie-compliance' ); ?></label>
						<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_background]" name="simple_gdpr_cookie_compliance_options[color][notice_background]" class="s_gdpr_c_n_color" data-alpha-enabled="true" value="<?php echo esc_attr( $notice_background_color ); ?>">
					</div>
					<div class="s_gdpr_c_n_group_field">
						<label for="simple_gdpr_cookie_compliance_options[color][notice_cookie_icon_color]"><?php echo esc_html__( 'Cookie Icon', 'simple-gdpr-cookie-compliance' ); ?></label>
						<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_cookie_icon_color]" name="simple_gdpr_cookie_compliance_options[color][notice_cookie_icon_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_cookie_icon_color ); ?>">	
					</div>
					<div class="s_gdpr_c_n_group_field">
						<label for="simple_gdpr_cookie_compliance_options[color][notice_text]"><?php echo esc_html__( 'Text', 'simple-gdpr-cookie-compliance' ); ?></label>
						<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_text]" name="simple_gdpr_cookie_compliance_options[color][notice_text]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_text_color ); ?>">
					</div>
					<div class="s_gdpr_c_n_group_field">
						<label for="simple_gdpr_cookie_compliance_options[color][notice_link_color]"><?php echo esc_html__( 'Link', 'simple-gdpr-cookie-compliance' ); ?></label>
						<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_link_color]" name="simple_gdpr_cookie_compliance_options[color][notice_link_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_link_color ); ?>">
					</div>
					<div class="s_gdpr_c_n_group_field">
						<label for="simple_gdpr_cookie_compliance_options[color][notice_link_hover_color]"><?php echo esc_html__( 'Link - On Hover', 'simple-gdpr-cookie-compliance' ); ?></label>
						<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_link_hover_color]" name="simple_gdpr_cookie_compliance_options[color][notice_link_hover_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_link_hover_color ); ?>">
					</div>
				</div>
			</div>

			<div class="s_gdpr_c_n_group_wrapper">
				<h4 class="s_grpd_c_n_group_title"><?php echo esc_html__( 'Close Button Color', 'simple-gdpr-cookie-compliance' ); ?></h4>
				<div class="s_gdpr_c_n_group">
					<div class="s_gdpr_c_n_group_field">
						<label for="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_bg_color]"><?php echo esc_html__( 'Background', 'simple-gdpr-cookie-compliance' ); ?></label>
						<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_bg_color]" name="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_bg_color]" class="s_gdpr_c_n_color" data-alpha-enabled="true" value="<?php echo esc_attr( $notice_box_close_btn_bg_color ); ?>">
					</div>
					<div class="s_gdpr_c_n_group_field">
						<label for="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_bg_hover_color]"><?php echo esc_html__( 'Background - On Hover', 'simple-gdpr-cookie-compliance' ); ?></label>
						<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_bg_hover_color]" name="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_bg_hover_color]" class="s_gdpr_c_n_color" data-alpha-enabled="true" value="<?php echo esc_attr( $notice_box_close_btn_bg_hover_color ); ?>">
					</div>
					<div class="s_gdpr_c_n_group_field">
						<label for="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_text_color]"><?php echo esc_html__( 'Text', 'simple-gdpr-cookie-compliance' ); ?></label>
						<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_text_color]" name="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_text_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_box_close_btn_text_color ); ?>">	
					</div>
					<div class="s_gdpr_c_n_group_field">
						<label for="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_hover_text_color]"><?php echo esc_html__( 'Text - On Hover', 'simple-gdpr-cookie-compliance' ); ?></label>
						<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_hover_text_color]" name="simple_gdpr_cookie_compliance_options[color][notice_box_close_btn_hover_text_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_box_close_btn_hover_text_color ); ?>">
					</div>
				</div>
			</div>

			<div class="s_gdpr_c_n_group_wrapper">
				<h4 class="s_grpd_c_n_group_title"><?php echo esc_html__( 'Accept Button Color', 'simple-gdpr-cookie-compliance' ); ?></h4>
				<div class="s_gdpr_c_n_group">
					<div class="s_gdpr_c_n_group_field">
						<label for="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_bg]"><?php echo esc_html__( 'Background', 'simple-gdpr-cookie-compliance' ); ?></label>
						<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_bg]" name="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_bg]" class="s_gdpr_c_n_color" data-alpha-enabled="true" value="<?php echo esc_attr( $notice_compliance_button_bg ); ?>">
					</div>
					<div class="s_gdpr_c_n_group_field">
						<label for="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_hover_bg_color]"><?php echo esc_html__( 'Background - On Hover', 'simple-gdpr-cookie-compliance' ); ?></label>
						<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_hover_bg_color]" name="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_hover_bg_color]" class="s_gdpr_c_n_color" data-alpha-enabled="true" value="<?php echo esc_attr( $notice_compliance_button_hover_bg_color ); ?>">
					</div>
					<div class="s_gdpr_c_n_group_field">
						<label for="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_border_color]"><?php echo esc_html__( 'Border', 'simple-gdpr-cookie-compliance' ); ?></label>
						<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_border_color]" name="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_border_color]" class="s_gdpr_c_n_color" data-alpha-enabled="true" value="<?php echo esc_attr( $notice_compliance_button_border_color ); ?>">	
					</div>
					<div class="s_gdpr_c_n_group_field">
						<label for="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_hover_border_color]"><?php echo esc_html__( 'Border - On Hover', 'simple-gdpr-cookie-compliance' ); ?></label>
						<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_hover_border_color]" name="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_hover_border_color]" class="s_gdpr_c_n_color" data-alpha-enabled="true" value="<?php echo esc_attr( $notice_compliance_button_hover_border_color ); ?>">
					</div>
					<div class="s_gdpr_c_n_group_field">
						<label for="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_text_color]"><?php echo esc_html__( 'Text', 'simple-gdpr-cookie-compliance' ); ?></label>
						<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_text_color]" name="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_text_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_compliance_button_text_color ); ?>">	
					</div>
					<div class="s_gdpr_c_n_group_field">
						<label for="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_hover_text_color]"><?php echo esc_html__( 'Text - On Hover', 'simple-gdpr-cookie-compliance' ); ?></label>
						<input type="text" id="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_hover_text_color]" name="simple_gdpr_cookie_compliance_options[color][notice_compliance_button_hover_text_color]" class="s_gdpr_c_n_color" value="<?php echo esc_attr( $notice_compliance_button_hover_text_color ); ?>">
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Custom CSS setting fields.
	 *
	 * @since    1.0.4
	 */
	public function custom_css_fields() {

		$custom_css = ! empty( $this->options['custom_css'] ) ? $this->options['custom_css'] : '';
		?>
		<div class="s_gdpr_c_n_field" id="s_gdpr_c_n_custom_css">
			<p>
				<label for="simple_gdpr_cookie_compliance_options[custom_css]">
					<?php echo esc_html__( 'CSS Codes', 'simple-gdpr-cookie-compliance' ); ?>
				</label>
				<textarea id="simple_gdpr_cookie_compliance_options[custom_css]" name="simple_gdpr_cookie_compliance_options[custom_css]" class="s_gdpr_c_n_number"><?php echo esc_html( $custom_css ); ?></textarea>
			</p>
		<?php
	}

	/**
	 * Function for sanitization of fields.
	 *
	 * @since 1.0.0
	 *
	 * @param array $inputs Settings.
	 */
	public function sanitize_fields( $inputs ) {

		if ( ! current_user_can( 'manage_options' ) ) {

			return $inputs;
		}

		$allowed_html_tags = array(
			'span' => array(
				'class' => array(),
			),
			'a'    => array(
				'class'  => array(),
				'href'   => array(),
				'target' => array(),
				'title'  => array(),
			),
			'i'    => array(
				'class' => array(),
			),
		);

		$inputs['notice_text'] = isset( $inputs['notice_text'] ) ? wp_kses( $inputs['notice_text'], $allowed_html_tags ) : '';

		$inputs['link']['link_type'] = isset( $inputs['link']['link_type'] ) ? sanitize_text_field( $inputs['link']['link_type'] ) : 'no_link';

		$inputs['link']['before_link'] = isset( $inputs['link']['before_link'] ) ? sanitize_text_field( $inputs['link']['before_link'] ) : '';

		$inputs['link']['after_link'] = isset( $inputs['link']['after_link'] ) ? sanitize_text_field( $inputs['link']['after_link'] ) : '';

		$inputs['link']['link_title'] = isset( $inputs['link']['link_title'] ) ? sanitize_text_field( $inputs['link']['link_title'] ) : '';

		$inputs['link']['link_url'] = isset( $inputs['link']['link_url'] ) ? esc_url_raw( $inputs['link']['link_url'] ) : '';

		$inputs['link']['page'] = isset( $inputs['link']['page'] ) ? sanitize_text_field( $inputs['link']['page'] ) : '';

		$inputs['show_in_new_tab'] = isset( $inputs['show_in_new_tab'] ) ? wp_validate_boolean( $inputs['show_in_new_tab'] ) : false;

		$inputs['show_close_btn'] = isset( $inputs['show_close_btn'] ) ? wp_validate_boolean( $inputs['show_close_btn'] ) : false;

		$inputs['show_cookie_icon'] = isset( $inputs['show_cookie_icon'] ) ? wp_validate_boolean( $inputs['show_cookie_icon'] ) : false;

		$inputs['accept_btn_title'] = isset( $inputs['accept_btn_title'] ) ? sanitize_text_field( $inputs['accept_btn_title'] ) : '';

		$inputs['style']['type'] = isset( $inputs['style']['type'] ) ? sanitize_text_field( $inputs['style']['type'] ) : 'custom_width';

		$inputs['style']['width'] = isset( $inputs['style']['width'] ) ? absint( $inputs['style']['width'] ) : 0;

		$inputs['style']['fullwidth_position'] = isset( $inputs['style']['fullwidth_position'] ) ? sanitize_text_field( $inputs['style']['fullwidth_position'] ) : '';

		$inputs['style']['customwidth_position'] = isset( $inputs['style']['customwidth_position'] ) ? sanitize_text_field( $inputs['style']['customwidth_position'] ) : '';

		$inputs['style']['enable_bg_overlay'] = isset( $inputs['style']['enable_bg_overlay'] ) ? wp_validate_boolean( $inputs['style']['enable_bg_overlay'] ) : false;

		$inputs['style']['top_offset'] = isset( $inputs['style']['top_offset'] ) ? absint( $inputs['style']['top_offset'] ) : 0;

		$inputs['style']['right_offset'] = isset( $inputs['style']['right_offset'] ) ? absint( $inputs['style']['right_offset'] ) : 0;

		$inputs['style']['bottom_offset'] = isset( $inputs['style']['bottom_offset'] ) ? absint( $inputs['style']['bottom_offset'] ) : 0;

		$inputs['style']['left_offset'] = isset( $inputs['style']['left_offset'] ) ? absint( $inputs['style']['left_offset'] ) : 0;

		$inputs['color']['notice_bg_overlay_color'] = isset( $inputs['color']['notice_bg_overlay_color'] ) ? sanitize_text_field( $inputs['color']['notice_bg_overlay_color'] ) : '';

		$inputs['color']['notice_background'] = isset( $inputs['color']['notice_background'] ) ? sanitize_text_field( $inputs['color']['notice_background'] ) : '';

		$inputs['color']['notice_text'] = isset( $inputs['color']['notice_text'] ) ? sanitize_hex_color( $inputs['color']['notice_text'] ) : '';

		$inputs['color']['notice_link_color'] = isset( $inputs['color']['notice_link_color'] ) ? sanitize_hex_color( $inputs['color']['notice_link_color'] ) : '';

		$inputs['color']['notice_link_hover_color'] = isset( $inputs['color']['notice_link_hover_color'] ) ? sanitize_hex_color( $inputs['color']['notice_link_hover_color'] ) : '';

		$inputs['color']['notice_cookie_icon_color'] = isset( $inputs['color']['notice_cookie_icon_color'] ) ? sanitize_hex_color( $inputs['color']['notice_cookie_icon_color'] ) : '';

		$inputs['color']['notice_compliance_button_bg'] = isset( $inputs['color']['notice_compliance_button_bg'] ) ? sanitize_text_field( $inputs['color']['notice_compliance_button_bg'] ) : '';

		$inputs['color']['notice_compliance_button_hover_bg_color'] = isset( $inputs['color']['notice_compliance_button_hover_bg_color'] ) ? sanitize_text_field( $inputs['color']['notice_compliance_button_hover_bg_color'] ) : '';

		$inputs['color']['notice_compliance_button_border_color'] = isset( $inputs['color']['notice_compliance_button_border_color'] ) ? sanitize_text_field( $inputs['color']['notice_compliance_button_border_color'] ) : '';

		$inputs['color']['notice_compliance_button_hover_border_color'] = isset( $inputs['color']['notice_compliance_button_hover_border_color'] ) ? sanitize_text_field( $inputs['color']['notice_compliance_button_hover_border_color'] ) : '';

		$inputs['color']['notice_compliance_button_text_color'] = isset( $inputs['color']['notice_compliance_button_text_color'] ) ? sanitize_hex_color( $inputs['color']['notice_compliance_button_text_color'] ) : '';

		$inputs['color']['notice_compliance_button_hover_text_color'] = isset( $inputs['color']['notice_compliance_button_hover_text_color'] ) ? sanitize_hex_color( $inputs['color']['notice_compliance_button_hover_text_color'] ) : '';

		$inputs['color']['notice_box_close_btn_bg_color'] = isset( $inputs['color']['notice_box_close_btn_bg_color'] ) ? sanitize_text_field( $inputs['color']['notice_box_close_btn_bg_color'] ) : '';

		$inputs['color']['notice_box_close_btn_bg_hover_color'] = isset( $inputs['color']['notice_box_close_btn_bg_hover_color'] ) ? sanitize_text_field( $inputs['color']['notice_box_close_btn_bg_hover_color'] ) : '';

		$inputs['color']['notice_box_close_btn_text_color'] = isset( $inputs['color']['notice_box_close_btn_text_color'] ) ? sanitize_hex_color( $inputs['color']['notice_box_close_btn_text_color'] ) : '';

		$inputs['color']['notice_box_close_btn_hover_text_color'] = isset( $inputs['color']['notice_box_close_btn_hover_text_color'] ) ? sanitize_hex_color( $inputs['color']['notice_box_close_btn_hover_text_color'] ) : '';

		$inputs['cookie_expire_time'] = isset( $inputs['cookie_expire_time'] ) ? absint( $inputs['cookie_expire_time'] ) : 0;

		$inputs['custom_css'] = isset( $inputs['custom_css'] ) ? sanitize_textarea_field( $inputs['custom_css'] ) : '';

		return $inputs;
	}
}
