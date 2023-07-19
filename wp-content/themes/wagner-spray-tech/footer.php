<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="c-site-footer wp-block-group alignfull has-black-background-color has-background" role="contentinfo" aria-label="<?php esc_attr_e( 'Footer', 'wagner-spray-tech' ); ?>">

		<?php get_template_part( 'template-parts/footer/footer-content' ); ?>

	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
