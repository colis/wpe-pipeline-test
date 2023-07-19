<?php
/**
 * Displays the footer content
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

?>

<div class="wp-block-group alignfull footer-wrap has-black-background-color has-background ">
	
	<div class="wp-block-group footer-wrap-row">

		<?php
			get_template_part( 'template-parts/footer/footer-newsletter-form' );
			get_template_part( 'template-parts/footer/footer-right-side' );
			get_template_part( 'template-parts/footer/footer-copyright' );
		?>

	</div>

</div>
