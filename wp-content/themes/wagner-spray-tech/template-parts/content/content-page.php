<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

?>

<?php do_action( 'wagner_spray_tech_page_header' ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php do_action( 'wagner_spray_tech_page_content_header' ); ?>

	<div class="entry-content">
		<?php
		do_action( 'wagner_spray_tech_page_content_before' );

		the_content();

		do_action( 'wagner_spray_tech_page_content_after' );
		?>
	</div><!-- .entry-content -->

	<?php do_action( 'wagner_spray_tech_page_content_footer' ); ?>

</article><!-- #post-<?php the_ID(); ?> -->

<?php do_action( 'wagner_spray_tech_page_footer' ); ?>
