<?php

use Kucrut\Vite;

if ( ! defined( 'WPINC' ) ) {
	die;
}

$handle = 'simple-gdpr-cookie-compliance-admin-app';

add_action( 'admin_enqueue_scripts', function ( $handle ): void {
	Vite\enqueue_asset(
		__DIR__ . '/app/dist',
		'app/src/main.tsx',
		[
			'handle' 						=> $handle,
			'dependencies' 			=> ['wp-api-fetch'],
			'css-dependencies' 	=> [],
			'css-media' 				=> 'all',
			'css-only' 					=> false,
			'in-footer' 				=> true,
		]
	);

	wp_localize_script(
		$handle,
		'sgccLocal',
		array(
			'adminURL'       => admin_url( '/' ),
			'siteURL'        => site_url( '/' ),
			'restNamespace'  => 'sgcc/v1',
			'version' 		   => SIMPLE_GDPR_COOKIE_COMPLIANCE_VERSION,
		)
	);
});
