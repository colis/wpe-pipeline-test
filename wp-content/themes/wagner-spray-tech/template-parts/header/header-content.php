<?php
/**
 * Displays header
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

$has_primary_nav = has_nav_menu( 'primary' );

?>

<header id="masthead" class="c-site-header" role="banner">

	<div class="o-container">

		<div class="c-site-header__content">
			<?php get_template_part( 'template-parts/header/site-branding' ); ?>
			<?php get_template_part( 'template-parts/header/navigation' ); ?>
			<?php get_template_part( 'template-parts/header/cta' ); ?>
		</div>

	</div>

</header>
