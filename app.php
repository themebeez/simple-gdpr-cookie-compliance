<?php

use Kucrut\Vite;

if ( ! defined( 'WPINC' ) ) {
	die;
}
if ( isset( $_GET['page'] ) && 'simple-gdpr-cookie-compliance' === $_GET['page'] ) { //phpcs:ignore
	$handle = 'simple-gdpr-cookie-compliance-admin-app';

	add_action(
		'admin_enqueue_scripts',
		function ( $handle ): void {
			Vite\enqueue_asset(
				__DIR__ . '/app/dist',
				'app/src/main.tsx',
				array(
					'handle'           => $handle,
					'dependencies'     => array(
						'wp-api-fetch',
						'lodash',
					),
					'css-dependencies' => array(),
					'css-media'        => 'all',
					'css-only'         => false,
					'in-footer'        => true,
				)
			);

			wp_localize_script(
				$handle,
				'simpleGDPRCookieLocal',
				array(
					'adminURL'      => admin_url( '/' ),
					'siteURL'       => site_url( '/' ),
					'restNamespace' => 'sgcc/v1',
					'version'       => SIMPLE_GDPR_COOKIE_COMPLIANCE_VERSION,
				)
			);
		}
	);
}
