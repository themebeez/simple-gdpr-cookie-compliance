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

if ( $args['enable_bg_overlay'] == true ) {
	?>
	<div id="s-gdpr-c-c-bg-overlay" class="s-gdpr-c-c-bg-overlay"></div>
	<?php
}
?>
<div class="sgcc-main-wrapper hidden <?php echo ( $args['wrapper_class'] ) ? esc_attr( $args['wrapper_class'] ) : ''; ?>">
    <div class="sgcc-cookies">
    	<?php
    	if ( $args['show_cookie_icon'] && $args['notice_type'] != 'full_width' ) {
	    	?>
	    	<span class="cookie-icon"><i class="sgcc sgcc-icon-cookie"></i></span>
	    	<?php
	    }
	    ?>
	    <div class="sgcc-notice-content">
		    <?php
	        if ( $args['notice'] ) {

	        	if ( $args['show_cookie_icon'] && $args['notice_type'] == 'full_width' ) {
			    	?>
			    	<span class="cookie-icon"><i class="sgcc sgcc-icon-cookie"></i></span>
			    	<?php
			    }
	        	?>
		        <div class="message-block">
			        <p>
			        	<?php
			        	if ( $args['link_type'] == 'no_link' ) {
			        		echo wp_kses_post( $args['notice'] );
			        	} else {
			        		$link_title = '';

				        	$link_url = '';

				        	$before_link = '';

				        	$after_link = '';

				        	if( $args['link_type'] == 'custom_url' ) {

				        		$link_title = $args['link_title'];
				        		$link_url = $args['link_url'];
				        	}

				        	if ( $args['link_type'] == 'page' ) {
				        		$link_title = $args['page_title'];
				        		$link_url = $args['page_link'];
				        	}

				        	$link = ( $args['before_link'] ) ? esc_html( $args['before_link'] ) : '';
				        	$link .= '<a href="' . esc_url( $link_url ) . '" ' . ( ( $args['show_in_new_tab'] ) ? 'target="_blank"' : 'target="_self"' ) . '>' . esc_html( $link_title ) . '</a>';
				        	$link .= ( $args['after_link'] ) ? esc_html( $args['after_link'] ) : ''; 

				        	echo wp_kses_post( $args['notice'] ) . $link;
			        	}
			        	?>
					</p>
				</div>
				<?php
			}
			if ( $args['btn_title'] ) {
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
		if ( $args['show_close_btn'] ) {
	    	?>
	        <span id="close-sgcc" class="close close-sgcc"><i class="sgcc sgcc-icon-close"></i></span>
	        <?php 
	    }
		?>
    </div>
</div>

