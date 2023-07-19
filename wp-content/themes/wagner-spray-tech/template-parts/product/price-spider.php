<?php
/**
 * Displays Price Spider Where to buy widget.
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

$upc = \get_field( 'upc' ) ?? '';

?>
<div class="c-where-to-buy">
		<div class="ps-widget c-where-to-buy__widget" ps-sku="<?php echo esc_attr( $upc ); ?>"></div>
</div>
