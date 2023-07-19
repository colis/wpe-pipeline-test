<?php
/**
 * Wagner Spray Tech Digital River Integration Create WordPress POst Functionality.
 *
 * @package WagnerSprayTechDigitalRiverIntegration\Data
 */

namespace WagnerSprayTechDigitalRiverIntegration\Data;

use WagnerSprayTechCore\BaseAbstract;
use WagnerSprayTechCore\Helper\PostTrait;
use WagnerSprayTechCore\Taxonomy\Product as ProductTaxonomy;
use WagnerSprayTechCore\Helper\TaxonomyTrait;
use WagnerSprayTechCore\PostType\Product as ProductCpt;

/**
 * Create WordPress Post.
 */
class Cpt extends BaseAbstract {

	use PostTrait;
	use TaxonomyTrait;

	/**
	 * Sensible defaults
	 *
	 * @var array
	 */
	private array $post_defaults = [
		'post_title'  => '',
		'post_status' => 'publish',
		'post_type'   => 'post',
		'post_author' => 1,
		'meta_input'  => [],
		'tax_input'   => [],
	];


	/**
	 * Create or update a WordPress Post object.
	 *
	 * @param array $post_data Post data array.
	 */
	public function create( array $post_data ): int {

		$post_data = wp_parse_args( $post_data, $this->post_defaults );

		if ( empty( $post_data['meta_input']['id'] ) ) {
			return 0;
		}

		// Check if post already created by input id meta.
		$existing_id = $this->get_post_ids_by_meta_key( 'id', $post_data['meta_input']['id'], $post_data['post_type'] );
		if ( ! empty( $existing_id ) ) {
			$post_data['ID']           = current( $existing_id );
			$post_data['post_content'] = get_the_content( post:$post_data['ID'] );
		}

		$this->compare_changes( $post_data );

		$meta_input = $post_data['meta_input'] ?? [];
		$tax_input  = $post_data['tax_input'] ?? [];

		unset( $post_data['meta_input'], $post_data['tax_input'] );

		$post_id = wp_insert_post( $post_data, true );

		$this->create_featured_image( $meta_input['product_image'] ?? ( $meta_input['thumbnail_image'] ?? '' ), $post_id );

		if ( empty( $post_data['ID'] ) ) {
			$this->app->get( Report::class )->create(
				post_id: $post_id,
				dr_id: $meta_input['id'],
				attribute: $post_data['post_type'],
				type: $this->app->get( Report::class )->type_collection['create'],
				change_log: 'Created {{' . $post_data['post_title'] . '}}'
			);
		}

		if ( is_wp_error( $post_id ) ) {
			error_log( $post_id->get_error_message() ); //phpcs:ignore
			return 0;
		}

		$this->update_meta_input( $post_id, $meta_input );
		$this->update_shadow_terms( $post_id, $tax_input );
		$this->update_taxonomy_terms( $post_id, $tax_input );
		$this->relate_children_posts( $post_id, $tax_input['shadow'][ ProductCpt::NAME ] ?? [] );

		return $post_id;
	}


	/**
	 * Create an attachment post and assign this to the post as featured image.
	 *
	 * @param string $image_url Image URL.
	 * @param int    $post_id Post ID.
	 *
	 * @return void
	 */
	private function create_featured_image( string $image_url, int $post_id ): void {

		if ( empty( $image_url ) ) {
			return;
		}

		$image_data     = file_get_contents( $image_url );
		$image_basename = pathinfo( $image_url, PATHINFO_BASENAME );
		$wp_upload_dir  = wp_upload_dir();
		$file_path      = $wp_upload_dir['path'] . '/' . $image_basename;
		$file_exists    = file_exists( $file_path );

		if ( $file_exists ) {
			$attachment_id = attachment_url_to_postid( $file_path );

			if ( 0 === $attachment_id ) {
				$attachment_id = wp_insert_attachment(
					[
						'post_mime_type' => wp_get_image_mime( $file_path ),
						'post_title'     => $image_basename,
						'post_content'   => '',
						'post_status'    => 'inherit',
					],
					$file_path,
					$post_id
				);
			}

			$attach_data = wp_generate_attachment_metadata( $attachment_id, $file_path );
			wp_update_attachment_metadata( $attachment_id, $attach_data );
			set_post_thumbnail( $post_id, $attachment_id );
			return;
		}

		file_put_contents( $file_path, $image_data );

		// Attach the image to the post as the featured image.
		$attachment_id = wp_insert_attachment(
			[
				'post_mime_type' => wp_get_image_mime( $file_path ),
				'post_title'     => $image_basename,
				'post_content'   => '',
				'post_status'    => 'inherit',
			],
			$file_path,
			$post_id
		);

		$attach_data = wp_generate_attachment_metadata( $attachment_id, $file_path );
		wp_update_attachment_metadata( $attachment_id, $attach_data );
		set_post_thumbnail( $post_id, $attachment_id );
	}


	/**
	 * Compare changes and report anything new.
	 *
	 * @param array $new_data New data.
	 *
	 * @return void
	 */
	private function compare_changes( array $new_data ): void {

		if ( empty( $new_data['ID'] ) ) {
			return;
		}

		$post       = get_post( $new_data['ID'], ARRAY_A );
		$meta_input = $new_data['meta_input'] ?? [];
		$tax_input  = $new_data['tax_input'] ?? [];

		unset( $new_data['post_content'], $new_data['meta_input'], $new_data['tax_input'] );

		// Check the post fields for changes.
		foreach ( $new_data as $key => $value ) {
			if ( trim($post[ $key ] ) != trim( $value ) ) { //phpcs:ignore
				$this->app->get( Report::class )->create(
					post_id: $new_data['ID'],
					dr_id: $meta_input['id'],
					attribute: $key,
					type: $this->app->get( Report::class )->type_collection['update'],
					change_log: sprintf( 'Changed {{%s}} from {{%s}} to {{%s}}', $key, $post[ $key ], $value )
				);
			}
		}

		// Check the acf meta for changes.
		foreach ( $meta_input as $key => $value ) {
			if ( get_field( $key, $new_data['ID'] ) != $value ) { //phpcs:ignore

				if ( is_array( $value ) ) {
					$value = implode( ', ', $value );
				}

				$this->app->get( Report::class )->create(
					post_id: $new_data['ID'],
					dr_id: $meta_input['id'],
					attribute: $key,
					type: $this->app->get( Report::class )->type_collection['update'],
					change_log: sprintf( 'Changed {{%s}} from {{%s}} to {{%s}}', $key, get_field( $key, $new_data['ID'] ), $value )
				);
			}
		}

		// Check the terms for changes.
		foreach ( $tax_input as $type => $taxonomy_terms ) {

			foreach ( $taxonomy_terms as $taxonomy => $terms ) {

				if ( 'shadow' === $type ) {
					$taxonomy = str_replace( '-', '_', $taxonomy ) . '_tax';
				}

				foreach ( $terms as $term ) {

					if ( empty( $term['slug'] ) ) {
						continue;
					}

					// @todo this needs to pivot on the shadow post meta id if available.
					$existing_term = get_term_by( 'slug', $term['slug'], $taxonomy );

					if ( ! $existing_term ) {
						$this->app->get( Report::class )->create(
							post_id: $new_data['ID'],
							dr_id: $meta_input['id'],
							attribute: $taxonomy,
							type: $this->app->get( Report::class )->type_collection['create'],
							change_log: sprintf( 'Added {{%s}} to {{%s}}', $term['name'], $taxonomy )
						);
					} elseif ( trim($existing_term->slug ) != trim( $term['slug'] ) ) { //phpcs:ignore
						$this->app->get( Report::class )->create(
							post_id: $new_data['ID'],
							dr_id: $meta_input['id'],
							attribute: $taxonomy,
							type: $this->app->get( Report::class )->type_collection['update'],
							change_log: sprintf( 'Updated {{%s}} in {{%s}}', $term['name'], $taxonomy )
						);
					}
				}
			}
		}
	}

	/**
	 * Update Post Meta using ACF for system compatibility.
	 *
	 * @param int   $post_id Post ID.
	 * @param array $meta_input Meta input.
	 *
	 * @return void
	 */
	public function update_meta_input( int $post_id, array $meta_input ): void {

		if ( empty( $meta_input ) ) {
			return;
		}

		foreach ( $meta_input as $meta_key => $meta_value ) {
			update_field( $meta_key, $meta_value, $post_id );
		}
	}

	/**
	 * Update Shadow terms by creating posts and updating post terms.
	 *
	 * @param int   $post_id Post ID.
	 * @param array $tax_input Taxonomy input.
	 *
	 * @return void
	 */
	public function update_shadow_terms( int $post_id, array $tax_input ): void {

		if ( empty( $tax_input['shadow'] ) ) {
			return;
		}

		foreach ( $tax_input['shadow'] as $post_type => $terms ) {

			if ( empty( $terms ) ) {
				continue;
			}

			$taxonomy   = str_replace( '-', '_', $post_type ) . '_tax';
			$term_array = [];

			wp_set_object_terms( $post_id, [], $taxonomy );

			foreach ( $terms as $term ) {

				if ( empty( $term ) ) {
					continue;
				}

				$existing_term = get_term_by( 'slug', $term['slug'], $taxonomy );

				if ( $existing_term ) {
					$term_array[] = absint( $existing_term->term_id );
					continue;
				}

				$args = [
					'post_title'  => $term['name'],
					'post_name'   => $term['slug'],
					'post_type'   => $post_type,
					'post_status' => 'publish',
					'meta_input'  => $term['meta_input'] ?? [],
				];

				$shadow_post_id = $this->create( $args );
				$term_id        = get_field( sprintf( 'shadow_%s_term_id', $taxonomy ), $shadow_post_id );

				if ( 0 === absint( $term_id ) ) {
					continue;
				}

				add_term_meta( $term_id, 'id', $term['meta_input']['id'], true );
				$term_array[] = absint( $term_id );

			}

			wp_set_post_terms( $post_id, $term_array, $taxonomy );

		}
	}

	/**
	 * Update taxonomy terms.
	 *
	 * @param int   $post_id Post ID.
	 * @param array $tax_input Taxonomy input.
	 *
	 * @return void
	 */
	public function update_taxonomy_terms( int $post_id, array $tax_input ): void {

		if ( empty( $tax_input['regular'] ) ) {
			return;
		}

		foreach ( $tax_input['regular'] as $taxonomy => $terms ) {

			wp_set_object_terms( $post_id, [], $taxonomy );

			foreach ( $terms as $term ) {

				if ( empty( $term ) ) {
					continue;
				}

				$new_term = term_exists( $term['slug'], $taxonomy );
				if ( ! $new_term ) {

					if ( empty( $term['name'] ) ) {
						continue;
					}

					$new_term = wp_insert_term(
						$term['name'],
						$taxonomy,
						[
							'slug' => $term['slug'],
						]
					);
				}

				if ( is_wp_error( $new_term ) ) {
					continue;
				}

				if ( ! empty( $term['meta_input']['id'] ) ) {
					add_term_meta( absint( $new_term['term_id'] ), 'id', $term['meta_input']['id'], true );
				}

				wp_set_object_terms( $post_id, absint( $new_term['term_id'] ), $taxonomy );

			}
		}
	}

	/**
	 * For most shadow terms one way linking is intended. For some these should be linked both ways. Eg product to product.
	 *
	 * @param int   $post_id Parent Post ID.
	 * @param array $tax_input Taxonomy Terms.
	 *
	 * @return void
	 */
	public function relate_children_posts( int $post_id, array $tax_input ): void {

		if ( empty( $tax_input ) ) {
			return;
		}

		$shadow_term_id = get_field( 'shadow_' . ProductTaxonomy::NAME . '_term_id', $post_id );

		foreach ( $tax_input as $term ) {

			$shadow_post_id = absint( $term['post_id'] );

			if ( 0 === $shadow_post_id ) {
				continue;
			}

			wp_set_post_terms( $shadow_post_id, $shadow_term_id, ProductTaxonomy::NAME, true );

		}
	}
}
