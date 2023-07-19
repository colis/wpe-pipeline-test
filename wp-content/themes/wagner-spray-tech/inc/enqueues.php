<?php
/**
 * Scripts and styles related functions.
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

/**
 * Enqueue frontend styles.
 *
 * @return void
 */
function wagner_spray_tech_frontend_styles() {
	// Enqueue Wagner Spray Tech styles.
	wp_register_style( 'wagner-spray-tech-styles', get_template_directory_uri() . '/dist/style-frontend.css', [], WAGNER_SPRAY_TECH_THEME_VERSION, 'all' );
	wp_enqueue_style( 'wagner-spray-tech-styles' );
}
add_action( 'wp_enqueue_scripts', 'wagner_spray_tech_frontend_styles' );

/**
 * Enqueue frontend scripts.
 *
 * @return void
 */
function wagner_spray_tech_frontend_scripts() {
	// Enqueue Wagner Spray Tech scripts.
	wp_register_script( 'wagner-spray-tech-scripts', get_template_directory_uri() . '/dist/frontend.js', [], WAGNER_SPRAY_TECH_THEME_VERSION, true );
	wp_enqueue_script( 'wagner-spray-tech-scripts' );
}
add_action( 'wp_enqueue_scripts', 'wagner_spray_tech_frontend_scripts' );

/**
 * Enqueue backend admin styles.
 *
 * @return void
 */
function wagner_spray_tech_editor_styles() {
	// Add support for editor styles.
	add_theme_support( 'editor-styles' );

	// Enqueue custom Wagner Spray Tech editor styles.
	add_editor_style( '/dist/admin.css' );
}
add_action( 'after_setup_theme', 'wagner_spray_tech_editor_styles' );

/**
 * Enqueue third-party scripts.
 *
 * @return void
 */
function wagner_spray_tech_third_party_scripts() {
}
add_action( 'wp_head', 'wagner_spray_tech_third_party_scripts' );

/**
 * Add preload / pre-connect / dns-prefetch requests for assets.
 *
 * @return void
 */
function wagner_spray_tech_preload_requests() {
	$logo     = get_field( 'logo', 'option' ) ?? '';
	$logo_url = $logo ? wp_get_attachment_image_url( $logo, 'full' ) : '';
	?>

	<?php if ( ! empty( $logo_url ) ) : ?>
		<link rel="preload" href="<?php echo esc_url( $logo_url ); ?>" as="image">
	<?php endif; ?>

	<link rel="preload" href="<?php echo esc_attr( WAGNER_SPRAY_TECH_THEME_DIST_URL . 'style-frontend.css?ver=' . WAGNER_SPRAY_TECH_THEME_VERSION ); ?>" as="style">
	<link rel="preload" href="<?php echo esc_attr( WAGNER_SPRAY_TECH_THEME_DIST_URL . 'frontend.js?ver=' . WAGNER_SPRAY_TECH_THEME_VERSION ); ?>" as="script">
	<!-- <link rel="preload" href="<?php echo esc_attr( WAGNER_SPRAY_TECH_THEME_DIST_URL . 'lib/glide.core.min.css?ver=' . WAGNER_SPRAY_TECH_THEME_VERSION ); ?>" as="style"> -->
	<!-- <link rel="preload" href="<?php echo esc_attr( WAGNER_SPRAY_TECH_THEME_DIST_URL . 'lib/glide.min.js?ver=' . WAGNER_SPRAY_TECH_THEME_VERSION ); ?>" as="script"> -->

	<!-- <link rel="dns-prefetch" href="https://www.googletagmanager.com"> -->

	<?php
}
add_action( 'wp_head', 'wagner_spray_tech_preload_requests' );

/**
 * Dequeue blocking third-party scripts/styles.
 *
 * @return void
 */
function wagner_spray_tech_dequeue_scripts_styles() {

	if ( ! is_user_logged_in() ) {
		wp_deregister_style( 'dashicons' );
	}
}
add_action( 'wp_enqueue_scripts', 'wagner_spray_tech_dequeue_scripts_styles', 999 );

/**
 * Defer or Async JavaScript files.
 *
 * @param string $tag The <script> tag for the enqueued script.
 * @param string $handle The script's registered handle.
 *
 * @return string
 */
function wagner_spray_tech_enqueue_script_attributes( $tag, $handle ) {

	if ( ! is_user_logged_in() ) {

		$async_handles       = [];
		$async_defer_handles = [];

		if ( in_array( $handle, $async_handles, true ) ) {
			return str_replace( ' src=', ' async src=', $tag );
		}

		if ( in_array( $handle, $async_defer_handles, true ) ) {
			return str_replace( ' src=', ' async defer src=', $tag );
		}
	}

	return $tag;
}
add_filter( 'script_loader_tag', 'wagner_spray_tech_enqueue_script_attributes', 10, 2 );
