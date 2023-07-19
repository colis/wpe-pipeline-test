<?php
/**
 * Blocks Class
 *
 * @package WagnerSprayTechBlocks\Blocks
 */

namespace WagnerSprayTechBlocks\Blocks;

use WagnerSprayTechCore\BaseAbstract;

/**
 * WordPress Core Functionality.
 */
class Blocks extends BaseAbstract {

	private const BLOCK_CATEGORY_SLUG  = 'wst-blocks';
	private const BLOCK_CATEGORY_LABEL = 'Wagner Spray Tech Blocks';

	/**
	 * All Registrable classes must include the register method.
	 *
	 * @return void
	 */
	public function register(): void {
	}

	/**
	 * Register custom block types.
	 *
	 * @return void
	 */
	public function wst_blocks_register_blocks(): void {
		// Find all custom blocks and register them.
		foreach ( glob( WAGNERSPRAYTECH_BLOCKS_PATH . '/build/*/block.json' ) as $filename ) {
			register_block_type( $filename );
		}
	}

	/**
	 * Add a custom block category.
	 *
	 * @param array $categories Array of categories for block types.
	 *
	 * @return array
	 */
	public function wst_blocks_register_block_category( array $categories ): array {

		return array_merge(
			[
				[
					'slug'  => self::BLOCK_CATEGORY_SLUG,
					'title' => self::BLOCK_CATEGORY_LABEL,
				],
			],
			$categories
		);
	}
}
