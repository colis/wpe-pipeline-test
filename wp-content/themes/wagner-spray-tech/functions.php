<?php
/**
 * Wagner Spray Tech functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WagnerSprayTech
 * @since 1.1.0
 */

/**
 * Define constants.
 */
define( 'WAGNER_SPRAY_TECH_THEME_VERSION', '0.0.1' );
define( 'WAGNER_SPRAY_TECH_THEME_DIR', trailingslashit( get_stylesheet_directory() ) );
define( 'WAGNER_SPRAY_TECH_THEME_URL', trailingslashit( get_stylesheet_directory_uri() ) );
define( 'WAGNER_SPRAY_TECH_THEME_DIST_URL', trailingslashit( get_stylesheet_directory_uri() . '/dist' ) );

if ( ! function_exists( 'wagner_spray_tech_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function wagner_spray_tech_setup() {

		/**
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1568, 9999 );

		/**
		 * Enable support for WooCommerce.
		 *
		 * @link https://woocommerce.com/document/woocommerce-theme-developer-handbook/
		 */
		add_theme_support( 'woocommerce' );

		/**
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			[
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
				'navigation-widgets',
			]
		);
	}
endif;
add_action( 'after_setup_theme', 'wagner_spray_tech_setup' );

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function wagner_spray_tech_skip_link_focus_fix() {
	// The following is minified via `terser --compress --mangle -- js/skip-link-focus-fix.js`.
	?>
	<script>
	/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'wagner_spray_tech_skip_link_focus_fix' );

/**
 * SVG Icons class.
 */
require get_template_directory() . '/classes/class-svg-icons.php';

/**
 * Enqueue styles/scripts.
 */
require get_template_directory() . '/inc/enqueues.php';

/**
 * Enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * SVG Icons related functions.
 */
require get_template_directory() . '/inc/icon-functions.php';

/**
 * Custom template tags for the theme.
 */
require get_template_directory() . '/inc/template-tags.php';
