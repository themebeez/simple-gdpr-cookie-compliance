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

$simple_gdpr_cookie_compliance_options = get_option( 'simple_gdpr_cookie_compliance_options' );
?>

<div class="sgcc-main-wrapper">
    <div class="sgcc-cookies">
    	<span class="cookie-icon"><i class="sgcc sgcc-icon-cookie"></i></span>
        <span class="close close-sgcc"><?php _e( '<i class="sgcc sgcc-icon-close"></i>', 'simple-gdpr-cookie-compliance' ); ?></span>
        <div class="message-block">
	        <p>
	        	<?php
	        	$notice_text = ! empty( $simple_gdpr_cookie_compliance_options['notice_text'] ) ? $simple_gdpr_cookie_compliance_options['notice_text'] : __( 'Our website uses cookies to make your online experience easier and better. By using our website, you consent to our use of cookies. For more information, read our <a href="https://yourwebsite.com/policy/">cookie policy</a> here.', 'simple-gdpr-cookie-compliance' );
	        	 echo wp_kses_post( $notice_text ); ?> 
				<?php
				if( ! empty( $simple_gdpr_cookie_compliance_options['link']['link_title'] ) && ! empty( $simple_gdpr_cookie_compliance_options['link']['link_url'] ) ) {
					?>
					<a href="<?php echo esc_url( $simple_gdpr_cookie_compliance_options['link']['link_url'] ); ?>"><?php echo esc_html( $simple_gdpr_cookie_compliance_options['link']['link_title'] ); ?></a>
					<?php
				}
				?>
			</p>
		</div><!-- // message-block -->
		<p class="cookie-compliance-button-block">
			<button class="close-sgcc cookie-compliance-button">I Accept</button>
		</p>
    </div>
</div>

