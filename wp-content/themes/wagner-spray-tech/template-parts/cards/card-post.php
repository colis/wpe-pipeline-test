<?php
/**
 * Post Card Template File
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || die();

?>

<article id="post-<?php the_ID(); ?>" class="grid-card c-card c-card-post">

	<a href="<?php the_permalink(); ?>">
		<div class="c-card__img">
			<?php the_post_thumbnail( 'card-thumbnail' ); ?>
		</div>
	</a>

	<div class="c-card__content">

		<div class="c-card__post-date">
			<?php echo esc_html( get_the_date() ); ?>
		</div>

		<h3 class="c-card__heading">
			<a href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
			</a>
		</h3>

		<p class="c-card__excerpt">
			<?php echo esc_html( get_the_excerpt() ); ?>
		</p>

	</div>

</article>
