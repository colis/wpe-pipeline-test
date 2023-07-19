<?php
/**
 * The template for displaying search form
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

?>

<form role="search" method="get" class="c-search-form js-search-form" action="/">
	<label>
		<span class="screen-reader-text">Search for:</span>
		<input type="search" class="search-field aa-input" placeholder="Search Wagner Spray Tech.." value="" name="s">
	</label>
	<button type="submit" class="search-submit button" value="Search" aria-label="<?php esc_html_e( 'Search Wagner Spray Tech', 'wagner-spray-tech' ); ?>">
		<span class="screen-reader-text"><?php esc_html_e( 'Search Wagner Spray Tech', 'wagner-spray-tech' ); ?></span>
		<?php echo wagner_spray_tech_get_icon_svg( 'search', 22 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</button>
</form>
