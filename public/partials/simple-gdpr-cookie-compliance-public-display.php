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

<div class="sgcc-main-wrapper hidden">
    <div class="sgcc-cookies">
    	<span class="cookie-icon"><i class="sgcc sgcc-icon-cookie"></i></span>
        <span id="close-sgcc" class="close close-sgcc"><i class="sgcc sgcc-icon-close"></i></span>
        <div class="message-block">
	        <p>
	        	<?php
	        	$simple_gdpr_cookie_compliance_notice_text = ! empty( $simple_gdpr_cookie_compliance_options['notice_text'] ) ? $simple_gdpr_cookie_compliance_options['notice_text'] : __( 'Our website uses cookies to provide you the best experience. However, by continuing to use our website, you agree to our use of cookies. For more information, read our <a href="#">Cookie Policy</a>.', 'simple-gdpr-cookie-compliance' );

	        	$simple_gdpr_cookie_compliance_link_type = ! empty( $simple_gdpr_cookie_compliance_options['link']['link_type'] ) ? $simple_gdpr_cookie_compliance_options['link']['link_type'] : 'no_link';

	        	$simple_gdpr_cookie_compliance_link_in_new_tab = isset( $simple_gdpr_cookie_compliance_options['show_in_new_tab'] ) ? absint( $simple_gdpr_cookie_compliance_options['show_in_new_tab'] ) : true;

	        	$simple_gdpr_cookie_compliance_link_target = '';

	        	if( $simple_gdpr_cookie_compliance_link_in_new_tab ) {

	        		$simple_gdpr_cookie_compliance_link_target = 'target="_blank"';
	        	} else {

	        		$simple_gdpr_cookie_compliance_link_target = 'target="_self"';
	        	}

	        	$simple_gdpr_cookie_compliance_link_title = '';

	        	$simple_gdpr_cookie_compliance_link = '';

	        	if( $simple_gdpr_cookie_compliance_link_type == 'custom_url' ) {

	        		$simple_gdpr_cookie_compliance_link_title = ! empty( $simple_gdpr_cookie_compliance_options['link']['link_title'] ) ? $simple_gdpr_cookie_compliance_options['link']['link_title'] : '';

	        		$simple_gdpr_cookie_compliance_link = ! empty( $simple_gdpr_cookie_compliance_options['link']['link_url'] ) ? $simple_gdpr_cookie_compliance_options['link']['link_url'] : '';
	        	}

	        	if( $simple_gdpr_cookie_compliance_link_type == 'page' ) {

	        		$simple_gdpr_cookie_compliance_page = ! empty( $simple_gdpr_cookie_compliance_options['link']['page'] ) ? absint( $simple_gdpr_cookie_compliance_options['link']['page'] ) : '';

	        		if( $simple_gdpr_cookie_compliance_page ) {

	        			$simple_gdpr_cookie_compliance_link_title = get_the_title( $simple_gdpr_cookie_compliance_page );

	        			$simple_gdpr_cookie_compliance_link = get_the_permalink( $simple_gdpr_cookie_compliance_page );
	        		}
	        	}

	        	$simple_gdpr_cookie_compliance_before_link = ! empty( $simple_gdpr_cookie_compliance_options['link']['before_link'] ) ? $simple_gdpr_cookie_compliance_options['link']['before_link'] : '';

	        	$simple_gdpr_cookie_compliance_after_link = ! empty( $simple_gdpr_cookie_compliance_options['link']['after_link'] ) ? $simple_gdpr_cookie_compliance_options['link']['after_link'] : '';

	        	$simple_gdpr_cookie_compliance_after_message = $simple_gdpr_cookie_compliance_before_link . '<a href="' . esc_url( $simple_gdpr_cookie_compliance_link ) . '" ' . $simple_gdpr_cookie_compliance_link_target . '>' . ' ' . esc_html( $simple_gdpr_cookie_compliance_link_title ) . '</a>' . ' ' . $simple_gdpr_cookie_compliance_after_link;

	        	if( $simple_gdpr_cookie_compliance_link_type == 'no_link' ) {

	        		echo wp_kses_post( $simple_gdpr_cookie_compliance_notice_text );
	        	} else {

	        		$simple_gdpr_cookie_compliance_full_text = $simple_gdpr_cookie_compliance_notice_text . $simple_gdpr_cookie_compliance_after_message;

	        		echo wp_kses_post( $simple_gdpr_cookie_compliance_full_text );
	        	}
	        	?>
			</p>
		</div><!-- // message-block -->
		<p class="cookie-compliance-button-block">
			<button id="sgcc-accept" class="close-sgcc cookie-compliance-button">
				<?php
				echo isset( $simple_gdpr_cookie_compliance_options['accept_btn_title'] ) ? esc_html( $simple_gdpr_cookie_compliance_options['accept_btn_title'] ) : __( 'Accept', 'simple-gdpr-cookie-compliance' );
				?>
			</button>
		</p>
    </div>
</div>

