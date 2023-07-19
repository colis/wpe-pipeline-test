<?php
/**
 * Template part for displaying Product hero Thumbnails Navigation.
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || die();

global $post;

$gallery = get_field( 'gallery' );
if ( is_string( $gallery ) ) {
	$gallery = json_decode( $gallery, true, 512 );
}
$thumbnail_image_template = <<<'HTML'
								<img loading='lazy' decoding='async' width='150' height='150' src='%s' alt='%s' data-full='%s'>
								HTML;


if ( count( $gallery['thumbnail'] ) <= 1 && ! wp_is_mobile() ) {
	return;
}

?>
<nav class="c-post-hero__thumbnails">
	<span class="thumbnails-nav" data-direction="prev"></span>
	<ul>
		<?php
		// Thumbnail images navigation.
		foreach ( $gallery['thumbnail'] as $k => $image_url ) {
			echo '<li>' . wp_kses_post( sprintf( $thumbnail_image_template, $image_url, get_the_title(), $gallery['product'][ $k ] ) ) . '</li>';
		}

		?>
	</ul>
	<span class="thumbnails-nav" data-direction="next"></span>
</nav>
