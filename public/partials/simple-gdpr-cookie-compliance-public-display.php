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
			<span class="cookie-icon"><i class="sgcc sgcc-icon-cookie"></i></span>
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
					<span class="cookie-icon"><i class="sgcc sgcc-icon-cookie"></i></span>
					<?php
				}
				?>
				<div class="message-block">
					<p>
						<?php
						if (
							isset( $args['link_type'] ) &&
							'no_link' === $args['link_type']
						) {
							echo wp_kses_post( $args['notice'] );
						} else {
							$link_title = '';

							$link_url = '';

							$before_link = isset( $args['before_link'] ) ? esc_html( $args['before_link'] ) : '';

							$after_link = isset( $args['after_link'] ) ? esc_html( $args['after_link'] ) : '';

							if (
								isset( $args['link_type'] ) &&
								'custom_url' === $args['link_type']
							) {

								$link_title = isset( $args['link_title'] ) ? $args['link_title'] : '';
								$link_url   = isset( $args['link_url'] ) ? $args['link_url'] : '';
							}

							if (
								isset( $args['link_type'] ) &&
								'page' === $args['link_type']
							) {
								$link_title = isset( $args['page_title'] ) ? $args['page_title'] : '';
								$link_url   = isset( $args['page_link'] ) ? $args['page_link'] : '';
							}

							$message_link  = $before_link . ' ';
							$message_link .= '<a href="' . esc_url( $link_url ) . '" ' . ( ( isset( $args['show_in_new_tab'] ) && true === $args['show_in_new_tab'] ) ? 'target="_blank"' : 'target="_self"' ) . '>' . esc_html( $link_title ) . ' </a>';
							$message_link .= ' ' . $after_link;

							echo wp_kses_post( $args['notice'] . ' ' . $message_link );
						}
						?>
					</p>
				</div>
				<?php
			}
			if ( isset( $args['btn_title'] ) && ! empty( $args['btn_title'] ) ) {
				?>
				<p class="cookie-compliance-button-block">
					<button id="sgcc-accept" class="close-sgcc cookie-compliance-button">
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
			<span id="close-sgcc" class="close close-sgcc"><i class="sgcc sgcc-icon-close"></i></span>
			<?php
		}
		?>
	</div>
</div>
