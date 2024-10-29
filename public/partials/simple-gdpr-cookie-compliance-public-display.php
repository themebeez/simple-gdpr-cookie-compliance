<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://themebeez.com/
 * @since      1.0.0
 *
 * @package    Simple_GDPR_Cookie_Compliance
 * @subpackage Simple_GDPR_Cookie_Compliance/public/partials
 */

if ( ! $args ) {
	return;
}

if (
	isset( $args['enable_bg_overlay'] ) &&
	true === $args['enable_bg_overlay']
) {
	?>
	<div id="s-gdpr-c-c-bg-overlay" class="s-gdpr-c-c-bg-overlay"></div>
	<?php
}
?>
<div class="sgcc-main-wrapper hidden <?php echo ( isset( $args['wrapper_class'] ) ) ? esc_attr( $args['wrapper_class'] ) : ''; ?>">
	<div class="sgcc-cookies">
		<?php
		if (
			(
				isset( $args['show_cookie_icon'] ) &&
				true === $args['show_cookie_icon']
			) &&
			(
				isset( $args['notice_type'] ) &&
				'full_width' !== $args['notice_type']
			)
		) {
			?>
			<span class="cookie-icon"><i class="sgcc sgcc-icon-cookie" aria-label="<?php echo esc_html__( 'Cookie Icon', 'simple-gdpr-cookie-compliance' ); ?>"></i></span>
			<?php
		}
		?>
		<div class="sgcc-notice-content">
			<?php
			if ( isset( $args['notice'] ) ) {

				if (
					(
						isset( $args['show_cookie_icon'] ) &&
						true === $args['show_cookie_icon']
					) &&
					(
						isset( $args['notice_type'] ) &&
						'full_width' === $args['notice_type']
					)
				) {
					?>
					<span class="cookie-icon"><i class="sgcc sgcc-icon-cookie" aria-label="<?php echo esc_html__( 'Cookie Icon', 'simple-gdpr-cookie-compliance' ); ?>"></i></span>
					<?php
				}
				?>
				<div class="message-block">
					<p><?php echo wp_kses_post( $args['notice'] ); ?></p>
				</div>
				<?php
			}
			if ( isset( $args['btn_title'] ) && ! empty( $args['btn_title'] ) ) {
				?>
				<p class="cookie-compliance-button-block">
					<button id="sgcc-accept" class="close-sgcc cookie-compliance-button" aria-label="<?php echo esc_html__( 'Accept Cookies', 'simple-gdpr-cookie-compliance' ); ?>">
						<?php echo esc_html( $args['btn_title'] ); ?>
					</button>
				</p>
				<?php
			}
			?>
		</div>
		<?php
		if (
			isset( $args['show_close_btn'] ) &&
			true === $args['show_close_btn']
		) {
			?>
			<span id="close-sgcc" class="close close-sgcc"><i class="sgcc sgcc-icon-close" aria-label="<?php echo esc_html__( 'Close Cookie Compliance Notice', 'simple-gdpr-cookie-compliance' ); ?>"></i></span>
			<?php
		}
		?>
	</div>
</div>
