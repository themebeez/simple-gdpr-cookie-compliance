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
	( isset( $args['enable_bg_overlay'] ) &&
	true === $args['enable_bg_overlay'] ) && 'pop_up' === $args['style']
) {
	?>
	<aside id="sgcc-overlay-mask" class="sgcc-overlay-mask"></aside>
	<?php
}


?>

<aside class="sgcc-main-wrapper hidden <?php echo ( isset( $args['wrapper_class'] ) ) ? esc_attr( $args['wrapper_class'] ) : ''; ?>"
data-layout="<?php echo ( isset( $args['style'] ) ? esc_attr( $args['style'] ) : '' ); ?>"
>
	<div class="sgcc-container">
		<?php
		if (
			(
				isset( $args['show_cookie_icon'] ) &&
				true === $args['show_cookie_icon']
			) &&
			(
				isset( $args['style'] ) &&
				'full_width' !== $args['style']
			)
		) {
			?>
			<span class="cookie-icon">
				<svg xmlns="http://www.w3.org/2000/svg" aria-label=<?php esc_attr_e( 'Cookie icon', 'simple-gdpr-cookie-compliance' ); ?> role="img" viewBox="0 0 24 24" width="32" height="32">
					<g id="_01_align_center" data-name="01 align center">
						<circle cx="9.5" cy="9.5" r="1.5"/>
						<circle cx="18.5" cy="1.5" r="1.5"/>
						<circle cx="21.5" cy="6.5" r="1.5"/>
						<circle cx="9.5" cy="14.5" r="1.5"/>
						<circle cx="14.5" cy="14.5" r="1.5"/>
						<path d="M12,24A12,12,0,0,1,12,0c.387,0,.769.021,1.146.057l.824.077.078.824a10,10,0,0,0,8.994,8.994l.824.078.077.824c.036.377.057.759.057,1.146A12.013,12.013,0,0,1,12,24ZM12,2A10,10,0,1,0,22,12c0-.057,0-.113,0-.17A12.006,12.006,0,0,1,12.17,2Z"/>
					</g>
				</svg>
			</span>
			<?php
		}
		?>
		<div class="sgcc-notice-content">
			<?php
			if ( isset( $args['notice_text'] ) ) {

				if (
					(
						isset( $args['show_cookie_icon'] ) &&
						true === $args['show_cookie_icon']
					) &&
					(
						isset( $args['style'] ) &&
						'full_width' === $args['style']
					)
				) {
					?>
					<span class="cookie-icon">
						<svg xmlns="http://www.w3.org/2000/svg" aria-label=<?php esc_attr_e( 'Cookie icon', 'simple-gdpr-cookie-compliance' ); ?> role="img" viewBox="0 0 24 24" width="32" height="32"><g id="_01_align_center" data-name="01 align center"><circle cx="9.5" cy="9.5" r="1.5"/><circle cx="18.5" cy="1.5" r="1.5"/><circle cx="21.5" cy="6.5" r="1.5"/><circle cx="9.5" cy="14.5" r="1.5"/><circle cx="14.5" cy="14.5" r="1.5"/><path d="M12,24A12,12,0,0,1,12,0c.387,0,.769.021,1.146.057l.824.077.078.824a10,10,0,0,0,8.994,8.994l.824.078.077.824c.036.377.057.759.057,1.146A12.013,12.013,0,0,1,12,24ZM12,2A10,10,0,1,0,22,12c0-.057,0-.113,0-.17A12.006,12.006,0,0,1,12.17,2Z"/></g></svg>
					</span>
					<?php
				}
				?>
				<div class="message-block">
					<p><?php echo wp_kses_post( $args['notice_text'] ); ?></p>
				</div>
				<?php
			}
			if ( isset( $args['accept_btn_title'] ) && ! empty( $args['accept_btn_title'] ) ) {
				?>
				<div class="cookie-compliance-button-block">
					<button type="button" id="sgcc-accept-button" class="close-sgcc cookie-compliance-button" aria-label="<?php echo esc_html__( 'Accept Cookies', 'simple-gdpr-cookie-compliance' ); ?>">
						<?php echo esc_html( $args['accept_btn_title'] ); ?>
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
			<button type="button" id="close-sgcc-button" class="close close-sgcc">
				<svg xmlns="http://www.w3.org/2000/svg" aria-label=<?php esc_attr_e( 'Cookie notice close button', 'simple-gdpr-cookie-compliance' ); ?> role="img" viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z"></path></svg>
			</button>
			<?php
		}
		?>
	</div>
</aside>
