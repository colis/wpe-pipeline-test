<?php
/**
 * Product CPT.
 *
 * @package WagnerSprayTechCore
 */

namespace WagnerSprayTechCore\PostType;

use WagnerSprayTechCore\Taxonomy\{
	Difficulty as DifficultyTaxonomy,
	ProductCategory as ProductCategoryTaxonomy,
	Product as ProductTaxonomy,
	ProductSeries as ProductSeriesTaxonomy,
	ProductType as ProductTypeTaxonomy,
	Promotion as PromotionTaxonomy,
	ProjectType as ProjectTypeTaxonomy};

/**
 * Product CPT.
 *
 * @package WagnerSprayTechCore\PostType
 */
class Product extends BasePostTypeAbstract {

	public const NAME = 'product';
	public const SLUG = 'product';
	public const ICON = 'dashicons-products';

	/**
	 * Get the admin columns array.
	 *
	 * @return array
	 */
	protected function get_admin_cols(): array {
		return [
			'product_image'               => [
				'title'          => 'Image',
				'featured_image' => 'thumbnail',
				'width'          => 80,
				'height'         => 80,
			],
			'product_id'                  => [
				'title'    => 'Product ID',
				'meta_key' => 'id', // phpcs:ignore
			],
			'purchasable'                 => [
				'title'    => 'Purchasable',
				'function' => function( $post ) {
					echo get_field( 'purchasable', $post->ID ) ? 'Yes' : 'No';
				},
			],
			'displayable'                 => [
				'title'    => 'Displayable',
				'function' => function( $post ) {
					echo get_field( 'displayable', $post->ID ) ? 'Yes' : 'No';
				},
			],
			'inventory_status'            => [
				'title'    => 'Inventory',
				'function' => function( $post ) {
					echo get_field( 'inventory_status', $post->ID ) ? 'Yes' : 'No';
				},
			],
			'price'                       => [
				'title'    => 'Price',
				'function' => function( $post ) {
					echo esc_attr( get_field( 'price', $post->ID ) );
				},
			],
			ProductTaxonomy::NAME         => [
				'title'    => 'Related Products',
				'taxonomy' => ProductTaxonomy::NAME,
			],
			ProductCategoryTaxonomy::NAME => [
				'title'    => 'Category',
				'taxonomy' => ProductCategoryTaxonomy::NAME,
			],
			ProductSeriesTaxonomy::NAME   => [
				'title'    => 'Product Series',
				'taxonomy' => ProductSeriesTaxonomy::NAME,
			],
			ProductTypeTaxonomy::NAME     => [
				'title'    => 'Product Type',
				'taxonomy' => ProductTypeTaxonomy::NAME,
			],
			'last_modified'               => [
				'title'      => 'Last Modified',
				'post_field' => 'post_modified',
			],
		];
	}

	/**
	 * Get the admin filters array.
	 *
	 * @return array
	 */
	protected function get_admin_filters(): array {
		return [
			ProductCategoryTaxonomy::NAME => [
				'taxonomy' => ProductCategoryTaxonomy::NAME,
			],
			ProductSeriesTaxonomy::NAME   => [
				'taxonomy' => ProductSeriesTaxonomy::NAME,
			],
		];
	}
}
