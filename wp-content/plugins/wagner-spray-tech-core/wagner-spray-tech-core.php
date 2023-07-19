<?php
/**
 * Plugin Name: Wagner Spray Tech Core Plugin
 * Plugin URI:  https://www.americaneagle.com/
 * Description: Core functionality for the Wagner Spray Tech site.
 * Version:     0.2.0
 * Author:      Americaneagle.com
 * Author URI:  https://www.americaneagle.com/
 * Text Domain: wagner-spray-tech-core
 * Domain Path: /languages
 *
 * @package WagnerSprayTechCore
 */

namespace WagnerSprayTechCore;

// Useful global constants.
define( 'WAGNERSPRAYTECH_CORE_PLUGIN_VERSION', '0.2.0' );
define( 'WAGNERSPRAYTECH_CORE_PLUGIN_URL', \plugin_dir_url( __FILE__ ) );
define( 'WAGNERSPRAYTECH_CORE_PLUGIN_PATH', \plugin_dir_path( __FILE__ ) );
define( 'WAGNERSPRAYTECH_CORE_PLUGIN_INC', WAGNERSPRAYTECH_CORE_PLUGIN_PATH . 'includes/' );

// Require Composer autoloader if it exists.
require_once ABSPATH . 'vendor/autoload.php';

// Initialise plugin.
( new Plugin() )->register();
