<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://themebeez.com/
 * @since      1.0.0
 *
 * @package    Simple_GDPR_Cookie_Compliance
 * @subpackage Simple_GDPR_Cookie_Compliance/admin/partials
 */
?>

<div class="sgcc-main-page-wrap">
<div class="sgcc-inner">
    <div class="sgcc-inner-entry content-main">
        <section class="sgcc-welcome-section sgcc-white-bg sgcc-section-spacing">
            <div class="sgcc-plugin-title">
                <h2><?php _e( 'Simple GDPR Cookie Compliance', 'simple-gdpr-cookie-compliance' ); ?></h2>
            </div><!-- .sgcc-plugin-title -->
            <div class="sgcc-plugin-intro">
                <p><?php _e( 'Simple GDPR Cookie Compliance is a simple and minimal WordPress plugin that helps you become GDPR compliant and notify users about your website&rsquo;s cookie policy or privacy policy. This plugin adds a small notice box at the bottom of right side of your website. You can easily set notify message as well as customize your notice with color options.', 'simple-gdpr-cookie-compliance' ); ?></p>

            </div><!-- .sgcc-plugin-intro -->
        </section><!-- .sgcc-welcome-section.sgcc-white-bg.sgcc-section-spacing.sgcc-section-shadow -->
        <section class="sgcc-options-settings-wrap">
            <form action='options.php' method='post'>
                <?php
                settings_fields('simple_gdpr_cookie_compliance_settings');
                do_settings_sections('simple_gdpr_cookie_compliance_settings');
                submit_button();
                ?>
            </form>
        </section><!-- .sgcc-options-settings-wrap -->
    </div><!-- .sgcc-col -->
</div><!-- .sgcc-row -->
</div><!-- . sgcc-main-page-wrap -->
