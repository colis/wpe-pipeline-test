<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="ps-key" content="2040-58f132aabd393d28900fbb9e">
	<meta name="ps-country" content="US" />
	<meta name="ps-language" content="en" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'wagner-spray-tech' ); ?></a>

	<?php

	do_action( 'wagner_spray_tech_single_before_header' );

	get_template_part( 'template-parts/header/header-content' );

	do_action( 'wagner_spray_tech_single_after_header' );

	?>

	<div id="content" class="c-site-content">
