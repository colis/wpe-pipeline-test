<?php
/**
 * Template part for displaying Product hero Details
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || die();

global $post;

$product_title = get_the_title();
$tag_line      = get_field( 'tag_line' );
$feature_list  = get_field( 'feature_list' );
$sku           = get_field( 'sku' );
$product_id    = get_field( 'id' );
$purchasable   = get_field( 'purchasable' );
$displayable   = get_field( 'displayable' );
$upc           = get_field( 'upc' );
$price         = get_field( 'price' );


?>
<?php if ( ! empty( $tag_line ) ) : ?>
<div class="wp-block-buttons is-layout-flex c-post-hero__details__category-btn">
	<div class="wp-block-button is-style-fill"><a
			class="wp-block-button__link has-black-background-color has-background wp-element-button has-x-small-font-size"
		><?php echo esc_attr( $tag_line ); ?></a>
	</div>
</div>
<?php endif; ?>


<h1 class="c-post-hero__details__title has-x-large-font-size"><?php echo esc_attr( $product_title ); ?></h1>
<h2 class="c-post-hero__details__price has-medium-font-size"><?php echo esc_attr( $price ); ?></h2>


<div class="c-post-hero__details__buy-now">
	<?php wagner_spray_tech_cart_btn( get_the_ID() ); ?>
</div>

<div class="c-post-hero__details__gallery">
<?php get_template_part( 'template-parts/content/product/content-hero/gallery-thumbnails' ); ?>
</div>

<?php if ( ! empty( $feature_list ) ) : ?>
<div class="c-post-hero__details__features has-small-font-size">
	<ul>
		<?php
		foreach ( $feature_list as $feature ) {
			echo sprintf( '<li>%s</li>', esc_attr( $feature['item'] ) );
		}
		?>
	</ul>
</div>
<?php endif; ?>
<?php get_template_part( 'template-parts/content/product/content-hero/support' ); ?>
