<?php
/**
 * Displays header site branding
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

$blog_info = get_bloginfo( 'name' );
$logo      = get_field( 'logo', 'option' ) ?? '';
$logo_src  = wp_get_attachment_image_src( $logo, 'site-logo-desktop' );

?>

<div class="c-site-header__branding">

	<?php if ( ! empty( $logo ) ) : ?>

		<div class="c-site-logo">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<img
					alt="<?php echo esc_attr( $blog_info ); ?>"
					class="c-site-logo__img"
					decoding="async"
					height="45"
					width="150"
					loading="eager"
					src="<?php echo esc_url( $logo_src[0] ); ?>"
				/>
			</a>
		</div>

	<?php endif; ?>

</div>
