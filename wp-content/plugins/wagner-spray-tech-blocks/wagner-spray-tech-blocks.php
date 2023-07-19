<?php
/**
 * Plugin Name: Wagner Spray Tech Blocks
 * Plugin URI:  https://www.americaneagle.com/
 * Description: Custom Gutenberg blocks made by Americaneagle.com.
 * Version:     0.1.0
 * Author:      Americaneagle.com
 * Author URI:  https://www.americaneagle.com/
 * Text Domain: wagner-spray-tech-blocks
 *
 * @package WagnerSprayTechBlocks
 */

namespace WagnerSprayTechBlocks;

// Useful global constants.
define( 'WAGNERSPRAYTECH_BLOCKS_VERSION', '0.1.0' );
define( 'WAGNERSPRAYTECH_BLOCKS_URL', \plugin_dir_url( __FILE__ ) );
define( 'WAGNERSPRAYTECH_BLOCKS_PATH', \plugin_dir_path( __FILE__ ) );
define( 'WAGNERSPRAYTECH_BLOCKS_INC', WAGNERSPRAYTECH_BLOCKS_PATH . 'includes/' );

// Require Composer autoloader.
require_once ABSPATH . 'vendor/autoload.php';

// Initialise plugin.
( new Plugin() )->register();
