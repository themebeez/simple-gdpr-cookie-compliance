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
			<span class="cookie-icon">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32"><circle cx="18.5" cy="1.5" r="1.5"/><circle cx="21.5" cy="6.5" r="1.5"/><path d="M24,12A12,12,0,1,1,12,0c.387,0,.769.021,1.146.057l.824.077.078.824a10,10,0,0,0,8.994,8.994l.824.078.077.824C23.979,11.231,24,11.613,24,12ZM8.5,7A1.5,1.5,0,1,0,10,8.5,1.5,1.5,0,0,0,8.5,7Zm0,7A1.5,1.5,0,1,0,10,15.5,1.5,1.5,0,0,0,8.5,14Zm7-1A1.5,1.5,0,1,0,17,14.5,1.5,1.5,0,0,0,15.5,13Z"/></svg>
			</span>
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
					<span class="cookie-icon">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32"><circle cx="18.5" cy="1.5" r="1.5"/><circle cx="21.5" cy="6.5" r="1.5"/><path d="M24,12A12,12,0,1,1,12,0c.387,0,.769.021,1.146.057l.824.077.078.824a10,10,0,0,0,8.994,8.994l.824.078.077.824C23.979,11.231,24,11.613,24,12ZM8.5,7A1.5,1.5,0,1,0,10,8.5,1.5,1.5,0,0,0,8.5,7Zm0,7A1.5,1.5,0,1,0,10,15.5,1.5,1.5,0,0,0,8.5,14Zm7-1A1.5,1.5,0,1,0,17,14.5,1.5,1.5,0,0,0,15.5,13Z"/></svg>
					</span>
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
				<div class="cookie-compliance-button-block">
					<button id="sgcc-accept" class="close-sgcc cookie-compliance-button" aria-label="<?php echo esc_html__( 'Accept Cookies', 'simple-gdpr-cookie-compliance' ); ?>">
						<?php echo esc_html( $args['btn_title'] ); ?>
					</button>
				</div>
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
			<span id="close-sgcc" class="close close-sgcc">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z"></path></svg>
			</span>
			<?php
		}
		?>
	</div>
</div>
