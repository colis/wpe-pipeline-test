<?php
/**
 * Displays social share component.
 *
 * @package WagnerSprayTech
 * @since 1.0.0
 */

?>

<div class="o-social-share">
	<a class="o-social-share__link o-social-share__facebook" href="https://www.facebook.com/sharer.php?u=<?php echo esc_url( get_the_permalink() ); ?>&amp;title=<?php echo esc_attr( get_the_title() ); ?>" target="_blank" rel="noopener noreferrer">
		<?php echo wagner_spray_tech_get_icon_svg( 'facebook_f', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<span class="screen-reader-text"><?php esc_html_e( 'Share on Facebook', 'wagner-spray-tech' ); ?></span>
	</a>

	<a class="o-social-share__link o-social-share__twitter" href="https://twitter.com/intent/tweet?url=<?php echo esc_url( get_the_permalink() ); ?>&text=<?php echo esc_attr( get_the_title() ); ?>" target="_blank" rel="noopener noreferrer">
		<?php echo wagner_spray_tech_get_icon_svg( 'twitter', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<span class="screen-reader-text"><?php esc_html_e( 'Share on Twitter', 'wagner-spray-tech' ); ?></span>
	</a>

	<a class="o-social-share__link o-social-share__mail" href="mailto:?subject=<?php echo esc_attr( get_the_title() ); ?>&amp;body=<?php echo esc_attr( get_the_title() ); ?> - <?php echo esc_url( get_the_permalink() ); ?>">
		<?php echo wagner_spray_tech_get_icon_svg( 'envelope', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<span class="screen-reader-text"><?php esc_html_e( 'Share via Email', 'wagner-spray-tech' ); ?></span>
	</a>
</div>
