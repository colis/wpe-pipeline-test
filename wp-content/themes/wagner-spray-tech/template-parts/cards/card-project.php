<?php
/**
 * Project Card Template File
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || die();

$card_post_id   = $args['post']['id'] ?? get_the_ID();
$card_title     = get_the_title( $card_post_id );
$card_link      = get_permalink( $card_post_id );
$featured_image = get_the_post_thumbnail( $card_post_id, 'card' );
$difficulty     = get_the_terms( $card_post_id, 'difficulty_tax' );
$project_type   = get_the_terms( $card_post_id, 'project_type_tax' );
$product        = get_the_terms( $card_post_id, 'product_tax' );

// For number of icons.
$difficulty_level = [
	'beginner'     => 1,
	'intermediate' => 2,
	'advanced'     => 3,
];

?>

<a href="<?php echo esc_url( $card_link ); ?>" class="wst-blocks-project-card">
	<?php if ( ! empty( $featured_image ) ) : ?>
		<figure class="wst-blocks-project-card__image">
			<?php echo wp_kses_post( $featured_image ); ?>
		</figure>
	<?php endif; ?>

	<article id="post-<?php echo esc_attr( $card_post_id ); ?>" class="wst-blocks-project-card__content">
		<?php if ( ! empty( $card_title ) ) : ?>
			<h3 class="wst-blocks-project-card__title">
				<?php echo esc_html( $card_title ); ?>
			</h3>
		<?php endif; ?>

		<dl class="wst-blocks-project-card__tag-list">
			<?php if ( ! empty( $difficulty ) ) : ?>
				<div class="wst-blocks-project-card__tag-list-item">
					<dt class="wst-blocks-project-card__tag-title">
						<?php esc_html_e( 'Difficulty', 'wagner-spray-tech' ); ?>:
					</dt>
					<dd class="wst-blocks-project-card__tag-content wst-blocks-project-card__tag-content--difficulty">
						<?php
						echo wp_kses_post(
							str_repeat(
								'<i class="icon icon-droplet-white"></i>',
								$difficulty_level[ $difficulty[0]->slug ]
							)
						);

						echo esc_html( $difficulty[0]->name );
						?>
					</dd>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $project_type ) ) : ?>
				<div class="wst-blocks-project-card__tag-list-item">
					<dt class="wst-blocks-project-card__tag-title">
						<?php esc_html_e( 'Project Type', 'wagner-spray-tech' ); ?>:
					</dt>
					<dd class="wst-blocks-project-card__tag-content">
						<?php echo esc_html( $project_type[0]->name ); ?>
					</dd>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $product ) ) : ?>
				<div class="wst-blocks-project-card__tag-list-item">
					<dt class="wst-blocks-project-card__tag-title">
						<?php esc_html_e( 'Product', 'wagner-spray-tech' ); ?>:
					</dt>
					<dd class="wst-blocks-project-card__tag-content">
						<?php echo esc_html( $product[0]->name ); ?>
					</dd>
				</div>
			<?php endif; ?>
		</dl>
	</article>
</a>
