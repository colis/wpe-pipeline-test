<?php
/**
 * Wagner Spray Tech Digital River Products sync.
 *
 * @package WagnerSprayTechDigitalRiverIntegration\Core
 */

namespace WagnerSprayTechDigitalRiverIntegration\Data;

use GuzzleHttp\Exception\GuzzleException;
use WagnerSprayTechCore\PostType\Product as ProductCpt;
use WagnerSprayTechCore\Taxonomy\ProductType as ProductTypeTaxonomy;
use WagnerSprayTechCore\Taxonomy\Product as ProductTaxonomy;
use WagnerSprayTechCore\Taxonomy\ProductCategory as ProductCategoryTaxonomy;
use WagnerSprayTechCore\Helper\PostTrait;

/**
 * Digital River products sync..
 */
class Product extends DataAbstract {


	use PostTrait;

	/**
	 * Object type.
	 *
	 * @var string
	 */
	public string $type = ProductCpt::NAME;

	/**
	 * API endpoint.
	 *
	 * @var string
	 */
	public string $api_endpoint = 'https://api.digitalriver.com/v1/shoppers/me/products';


	/**
	 * Inventory status endpoint.
	 *
	 * @var string
	 */
	public string $inventory_status_endpoint = 'https://api.digitalriver.com/v1/shoppers/me/products/%s/inventory-status';



	/**
	 * Related products API endpoint.
	 *
	 * @var string
	 */
	public string $related_products_api_endpoint = 'https://api.digitalriver.com/v1/shoppers/me/products/%s/point-of-promotions/PDP_Suggested_Products/offers';



	/**
	 * Image URL path.
	 *
	 * @var string
	 */
	public string $image_url_path = 'https://drh1.img.digitalriver.com/DRHM/Storefront/Company/wagner/images/';



	/**
	 * Store ID.
	 *
	 * @var string
	 */
	public string $store_id = '39064500';

	/**
	 * Custom arguments.
	 *
	 * @var array|array[]
	 */
	public array $custom_args = [
		'query' => [
			'expand'   => 'product,product.pricing, product.customAttributes, customAttributes, offer',
			'pageSize' => 20,
		],
	];


	/**
	 * Site option name.
	 *
	 * @var string
	 */
	public string $site_option_name = 'wst_digital_river_product_sync_';


	/**
	 * Get a page of products.
	 *
	 * @param int  $page_number Page number to get.
	 * @param bool $expand Whether to expand the response or not.
	 *
	 * @return array
	 * @throws GuzzleException On connection error.
	 */
	public function get_page( int $page_number = 1, bool $expand = false ): array {

		if ( ! $expand ) {
			$this->custom_args['query']['expand'] = '';
		}

		$this->custom_args['query']['pageNumber'] = $page_number;

		$data = $this->get_array_from_response( $this->get_request( $this->api_endpoint, $this->get_args() ) );

		return $this->transform_multiple( $data ) ?? [];
	}


	/**
	 * Just return the totals for all products.
	 *
	 * @return array|int[]
	 */
	public function get_totals(): array {

		$rtn = [
			'total_results' => 0,
			'total_pages'   => 0,
		];

		try {
			$request = $this->get_array_from_response( $this->get_request( $this->api_endpoint, $this->get_args() ) );
			$rtn     = [
				'total_results' => $request['products']['totalResults'],
				'total_pages'   => $request['products']['totalResultPages'],
			];

		} catch ( GuzzleException $e ) {
			echo esc_html( 'Error: ' . $e->getMessage() );
		}

		return $rtn;
	}


	/**
	 * Update a page worth of products.
	 *
	 * @param int $page_number Page number to update.
	 *
	 * @return array
	 */
	public function update_page( int $page_number ): array {

		$rtn = [
			'page' => $page_number,
		];

		$data = get_option( sprintf( '%spage_%d', $this->site_option_name, $page_number ) );

		if ( empty( $data ) ) {
			return $rtn;
		}

		array_map( [ $this->app->get( Cpt::class ), 'create' ], $data );
		delete_option( sprintf( '%spage_%d', $this->site_option_name, $page_number ) );

		return $rtn;
	}




	/**
	 * Set the data and total counts;
	 *
	 * @param array $input_data Input data.
	 *
	 * @return array
	 */
	protected function transform_multiple( array $input_data ): array {

		$this->set_total_results( (int) $input_data['products']['totalResults'] );
		$this->set_total_pages( (int) $input_data['products']['totalResultPages'] );

		return array_map( [ $this, 'transform_single' ], $input_data['products']['product'] ) ?? [];
	}

	/**
	 * Transform single item.
	 *
	 * @param array $input_data Each single item input data.
	 *
	 * @return array
	 * @throws GuzzleException On connection error.
	 */
	protected function transform_single( array $input_data ): array {

		$input_data = $input_data['product'] ?? $input_data;
		$product_id = absint( $input_data['id'] );

		// wp insert post array.
		$rtn = [
			'post_title'   => $input_data['displayName'],
			'post_excerpt' => $input_data['shortDescription'] ?? '',
			'post_status'  => 'publish',
			'post_type'    => ProductCpt::NAME,
		];

		$rtn['meta_input'] = [

			'name'                             => $input_data['name'] ?? '',
			'id'                               => $product_id,
			'sku'                              => $input_data['sku'] ?? '',
			'displayable'                      => $this->convert_string_to_boolean( $input_data['displayableProduct'] ),
			'purchasable'                      => $this->convert_string_to_boolean( $input_data['purchasable'] ),
			'short_description'                => apply_filters( 'acf_the_content', $input_data['shortDescription'] ?? '' ),
			'long_description'                 => apply_filters( 'acf_the_content', $input_data['longDescription'] ?? '' ),
			'prop_65_lead'                     => $this->convert_string_to_boolean( $this->filter_value_by_name( $input_data['customAttributes']['attribute'] ?? [], 'Prop65Lead' ) ),
			'proo_65_wood'                     => $this->convert_string_to_boolean( $this->filter_value_by_name( $input_data['customAttributes']['attribute'] ?? [], 'Prop65Wood' ) ),
			'needs_restricted_shipping_option' => $this->convert_string_to_boolean( $this->filter_value_by_name( $input_data['customAttributes']['attribute'] ?? [], 'needsRestrictedShippingOption' ) ),
			'upc'                              => $this->filter_value_by_name( $input_data['customAttributes']['attribute'] ?? [], 'upc' ),
			'weight'                           => $this->filter_value_by_name( $input_data['customAttributes']['attribute'] ?? [], 'weight' ),
			'unit'                             => $this->filter_value_by_name( $input_data['customAttributes']['attribute'] ?? [], 'unit' ),
			// Seo.
			'keywords'                         => $input_data['keywords'] ?? '',
			// Gallery.
			'product_image'                    => $input_data['productImage'],
			'thumbnail_image'                  => $input_data['thumbnailImage'],

			'gallery'                          => $this->get_gallery_images( $input_data ),

			// Pricing.
			'price'                            => $input_data['pricing']['formattedListPrice'] ?? '',

			// Add to cart.
			'add_to_cart'                      => sprintf( 'https://store.wagnerspraytech.com/store/wagner/buy/productID.%s/quantity.1/ThemeID.%s', $product_id, $this->store_id ),
			'add_to_cart_pixel'                => sprintf(
				'https://tags.w55c.net/rs?id=b9f2490bd6a740818b68201b78dc7773&t=checkout&tx=&sku=%s&price=%s&rurl=https://store.wagnerspraytech.com/store/wagner/buy/productID.%s/quantity.1/ThemeID.%s',
				$input_data['sku'],
				$input_data['pricing']['formattedListPrice'] ?? '',
				$product_id,
				$this->store_id
			),

			// Inventory Status.
			'inventory_status'                 => $this->convert_string_to_boolean( $this->get_inventory_status( $product_id ) ),

			// Digital River data.
			'digital_river'                    => [
				'uri' => $input_data['uri'],
			],
			// Unsure if these are needed.
			'external_ref_id'                  => $input_data['externalReferenceId'],
			'manufacturer_name'                => $input_data['manufacturerName'],
			'manufacturer_part_number'         => $input_data['manufacturerPartNumber'],
			'minimum_quantity'                 => $input_data['minimumQuantity'],
			'maximum_quantity'                 => $input_data['maximumQuantity'],
		];

		$product_type_tax = $this->get_array_from_response( $this->get_request( $input_data['categories']['uri'] ?? '' ) );

		$rtn['tax_input'] = [
			'shadow'  => [
				ProductCpt::NAME => $this->get_related_products( $product_id ),
			],
			'regular' => [
				ProductCategoryTaxonomy::NAME => array_map(
					[
						$this,
						'get_product_category',
					],
					$product_type_tax['categories']['category'] ?? []
				),
				ProductTypeTaxonomy::NAME     => array_map(
					[
						$this,
						'transform_product_type_term',
					],
					$product_type_tax['categories']['category'] ?? []
				),
			],
		];

		return $rtn;
	}


	/**
	 * Return all available product gallery images.
	 *
	 * @param array $input_data Input data.
	 *
	 * @return array
	 */
	private function get_gallery_images( array $input_data ): array {

		$product_images         = [];
		$thumbnail_images       = [];
		$total_available_images = 20;
		$count                  = 1;

		do {
			$product_images[]   = $this->filter_value_by_name( $input_data['customAttributes']['attribute'] ?? [], 'Product_Image_' . $count );
			$thumbnail_images[] = $this->filter_value_by_name( $input_data['customAttributes']['attribute'] ?? [], 'Thumbnail_Image_' . $count );
			++$count;
		} while ( $count < $total_available_images );

		return [

			'product'   =>
			array_filter(
				array_map(
					function( $image ) {

						if ( empty( $image ) ) {
							return $image;
						}

						return $this->image_url_path . $image;
					},
					$product_images
				)
			),

			'thumbnail' =>
			array_filter(
				array_map(
					function( $image ) {

						if ( empty( $image ) ) {
							return $image;
						}

						return $this->image_url_path . $image;
					},
					$thumbnail_images
				)
			),

		];
	}


	/**
	 * Return the inventory status of a product.
	 *
	 * @param string $product_id The product id.
	 *
	 * @return bool
	 * @throws GuzzleException If the request fails.
	 */
	private function get_inventory_status( string $product_id ): string {

		$endpoint = sprintf( $this->inventory_status_endpoint, $product_id );
		$args     = $this->get_args();
		unset( $args['query']['pageNumber'] );

		$req = $this->get_request( $endpoint, $args );
		$res = $this->get_array_from_response( $req );

		return (string) $res['inventoryStatus']['productIsInStock'];
	}



	/**
	 * Return an array of related product shadow term ids.
	 *
	 * @param string $product_id The product id.
	 *
	 * @return array
	 * @throws GuzzleException If the request fails.
	 */
	private function get_related_products( string $product_id ): array {

		$endpoint = sprintf( $this->related_products_api_endpoint, $product_id );
		$args     = $this->get_args();
		unset( $args['query']['pageNumber'] );

		$req = $this->get_request( $endpoint, $args );
		$res = $this->get_array_from_response( $req );
		$rtn = [];

		if ( ! isset( $res['offers']['offer'] ) ) {
			return $rtn;
		}

		$related_products = $res['offers']['offer'] ? current( $res['offers']['offer'] )['productOffers']['productOffer'] : [];

		if ( ! empty( $related_products ) ) {
			$related_product_ids = wp_list_pluck( $related_products, 'id' );

			foreach ( $related_product_ids as $p_id ) {

				$post_id = current( $this->get_post_ids_by_meta_key( 'id', $p_id, ProductCpt::NAME ) ) ?? false;

				if ( ! $post_id ) {
					continue;
				}

				$shadow_term_id = get_field( 'shadow_' . ProductTaxonomy::NAME . '_term_id', $post_id );
				$term           = get_term( $shadow_term_id, ProductTaxonomy::NAME );

				if ( ! $term ) {
					continue;
				}

				$rtn[ $p_id ] = [
					'slug'    => $term->slug,
					'name'    => $term->name,
					'id'      => $shadow_term_id,
					'post_id' => $post_id,
				];

			}
		}

		return $rtn;
	}




	/**
	 * Transform product type term.
	 *
	 * @param array $input_data Input data.
	 *
	 * @return array
	 */
	private function transform_product_type_term( array $input_data ): array {

		if ( empty( $input_data ) ) {
			return [];
		}

		if ( 'All Products' === $input_data['displayName'] ) {
			return [];
		}

		$uri_array = explode( '/', $input_data['uri'] );
		$id        = end( $uri_array );

		return [
			'name'       => $input_data['displayName'],
			'slug'       => sanitize_title( $input_data['displayName'] ),
			'meta_input' => [
				'id' => $id,
			],
		];
	}

	/**
	 * Infer the product category from the display name of the input product categories.
	 *
	 * @param array $input_data Input data.
	 *
	 * @return string
	 */
	private function get_product_category( array $input_data ): array {

		$rtn = [
			'name' => 'Product',
			'slug' => 'product',
		];

		if ( empty( $input_data['displayName'] ) ) {
			return $rtn;
		}

		switch ( true ) {

			case str_contains( strtolower( $input_data['displayName'] ), 'accessories' ):
			case str_contains( strtolower( $input_data['displayName'] ), 'accessory' ):
				$rtn = [
					'name' => 'Accessory',
					'slug' => 'accessory',
				];
				break;

			case str_contains( strtolower( $input_data['displayName'] ), 'parts' ):
			case str_contains( strtolower( $input_data['displayName'] ), 'part' ):
				$rtn = [
					'name' => 'Part',
					'slug' => 'part',
				];
				break;

		}

		return $rtn;
	}
}
