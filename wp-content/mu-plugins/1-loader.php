<?php // phpcs:ignoreFile

defined( 'ABSPATH' ) || exit;

// Composer autoloader -- must be first.
if ( ! is_readable( ABSPATH . 'vendor/autoload.php' ) ) {
	// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_trigger_error -- required for detecting broken deploys.
	trigger_error( 'Cannot find Composer autoload.', E_USER_ERROR );
}
require_once ABSPATH . 'vendor/autoload.php';

// Load your mu-plugins here!
$ae_mu_plugins = [];

foreach ( $ae_mu_plugins as $file_path ) {
	if ( ! file_exists( __DIR__ . $file_path ) ) {
		wp_die( 'Check mu-plugins loader: ' . esc_html( $file_path ) );
		exit;
	}

	require_once __DIR__ . $file_path;
}
