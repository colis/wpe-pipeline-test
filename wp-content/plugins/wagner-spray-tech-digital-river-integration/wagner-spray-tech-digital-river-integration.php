<?php
/**
 * Plugin Name: Wagner Spray Tech Digital River Integration
 * Plugin URI:  https://www.americaneagle.com/
 * Description:
 * Version:     0.2.0
 * Author:      Americaneagle.com
 * Author URI:  https://www.americaneagle.com/
 * Text Domain: wagner-spray-tech-digital-river-integration
 * Domain Path: /languages
 *
 * @package WagnerSprayTechDigitalRiverIntegration
 */

namespace WagnerSprayTechDigitalRiverIntegration;

// Useful global constants.
define( 'WAGNERSPRAYTECH_DIGITALRIVER_INTEGRATION_VERSION', '0.0.1' );
define( 'WAGNERSPRAYTECH_DIGITALRIVER_INTEGRATION_URL', \plugin_dir_url( __FILE__ ) );
define( 'WAGNERSPRAYTECH_DIGITALRIVER_INTEGRATION_PATH', \plugin_dir_path( __FILE__ ) );
define( 'WAGNERSPRAYTECH_DIGITALRIVER_INTEGRATION_INC', WAGNERSPRAYTECH_DIGITALRIVER_INTEGRATION_PATH . 'includes/' );

// Require Composer autoloader if it exists.
if ( file_exists( WAGNERSPRAYTECH_DIGITALRIVER_INTEGRATION_PATH . '/vendor/autoload.php' ) ) {
	require_once WAGNERSPRAYTECH_DIGITALRIVER_INTEGRATION_PATH . 'vendor/autoload.php';
}

// Initialise plugin.
( new Plugin() )->register();
