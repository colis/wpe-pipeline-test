<?php
/**
 * Wagner Spray Tech Core Plugin
 *
 * @package WagnerSprayTechCore
 */

namespace WagnerSprayTechCore;

use WagnerSprayTechCore\Acf\AdvancedCustomFields;
use WagnerSprayTechCore\Core\Core;
use WagnerSprayTechCore\Gutenberg\Gutenberg;
use WagnerSprayTechCore\Nav\Nav;
use WagnerSprayTechCore\PostType\{Document as DocumentCpt,
	Faq as FaqCpt,
	HowTo as HowToCpt,
	Product as ProductCpt,
	ProductSeries as ProductSeriesCpt,
	Project as ProjectCpt,
	ProjectType as ProjectTypeCpt,
	Testimonial as TestimonialCpt
};
use WagnerSprayTechCore\Search\Search;
use WagnerSprayTechCore\Slug\Slug;
use WagnerSprayTechCore\Taxonomy\{Difficulty as DifficultyTax,
	ProductCategory as ProductCategoryTax,
	ProductSeries as ProductSeriesTax,
	Product as ProductTax,
	ProductType as ProductTypeTax,
	ProjectType as ProjectTypeTax,
	Promotion as PromotionTax
};
use WagnerSprayTechCore\Image\{
	Card as CardImage
};
use WagnerSprayTechCore\Purchase\PriceSpider;



/**
 * Wagner Spray Tech Core Plugin main class.
 */
class Plugin extends BaseAbstract {

	public const CUSTOM_POST_TYPES = [
		ProductCpt::class,
		ProductSeriesCpt::class,
		ProjectCpt::class,
		ProjectTypeCpt::class,
		HowToCpt::class,
		FaqCpt::class,
		TestimonialCpt::class,
		DocumentCpt::class,
	];

	public const TAXONOMIES = [
		ProductCategoryTax::class,
		ProductSeriesTax::class,
		ProductTypeTax::class,
		ProjectTypeTax::class,
		ProductTax::class,
		DifficultyTax::class,
		PromotionTax::class,
	];

	public const IMAGE_SIZES = [
		CardImage::class,
	];


	/**
	 * Set up the container deps and fire off all WordPress hooks used in this plugin.
	 */
	public function register(): void {
		try {
			$this->activation_hooks();
			$this->actions();
			$this->filters();
		} catch ( \Exception $e ) {
			echo esc_html( $e->getMessage() );
		}
	}

	/**
	 * Plugin activation and deactivation hooks.
	 *
	 * @return void
	 */
	private function activation_hooks(): void {
		register_activation_hook( __FILE__, [ $this->app->get( Core::class ), 'activation_hook' ] );
		register_deactivation_hook( __FILE__, [ $this->app->get( Core::class ), 'deactivation_hook' ] );
	}

	/**
	 * Invoke all add_action, remove_action, do_action hooks in here.
	 *
	 * @return void
	 */
	private function actions(): void {

		// Load text domain.
		add_action( 'init', [ $this->app->get( Core::class ), 'i18n' ] );

		// Enqueue scripts and styles.
		add_action( 'wp_enqueue_scripts', [ $this->app->get( Core::class ), 'scripts' ] );
		add_action( 'wp_enqueue_scripts', [ $this->app->get( Core::class ), 'styles' ] );
		add_action( 'wp_enqueue_scripts', [ $this->app->get( PriceSpider::class ), 'scripts' ] );

		// Enqueue admin scripts and styles.
		add_action( 'admin_enqueue_scripts', [ $this->app->get( Core::class ), 'admin_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this->app->get( Core::class ), 'admin_styles' ] );

		// Enqueue admin block editor assets.
		add_action( 'enqueue_block_editor_assets', [ $this->app->get( Gutenberg::class ), 'enqueue_editor_assets' ] );

		// Acf.
		add_action( 'acf/init', [ $this->app->get( AdvancedCustomFields::class ), 'register_acf_settings_page' ] );
		add_action( 'acf/init', [ $this->app->get( AdvancedCustomFields::class ), 'register_acf_local_fields' ] );

		// Nav Menus.
		add_action( 'after_setup_theme', [ $this->app->get( Nav::class ), 'register_nav_menus' ] );
		add_filter( 'nav_menu_link_attributes', [ $this->app->get( Nav::class ), 'nav_menu_link_attributes' ], 10, 4 );

		// Gutenberg Theme support.
		add_action( 'after_setup_theme', [ $this->app->get( Gutenberg::class ), 'register_gutenberg_theme_support' ] );

		// CPT.
		foreach ( self::CUSTOM_POST_TYPES as $cpt_classname ) {
			add_action( 'init', [ $this->app->get( $cpt_classname ), 'register' ] );
		}

		// Taxonomies.
		foreach ( self::TAXONOMIES as $tax_classname ) {
			add_action( 'init', [ $this->app->get( $tax_classname ), 'register' ] );
		}

		// Image sizes.
		foreach ( self::IMAGE_SIZES as $image_size ) {
			add_action( 'init', [ $this->app->get( $image_size ), 'register' ] );
		}

		// Search.
		add_action( 'template_redirect', [ $this->app->get( Search::class ), 'default_search_url_rewrite' ] );

		// Complete plugin loaded hook.
		do_action( 'wagnerspraytech_core_plugin_loaded' );
	}

	/**
	 * Invoke all add_filter, remove_filter, do_filter hooks in here.
	 *
	 * @return void
	 */
	private function filters(): void {
		// Adds support for duplicate slugs for specific CPT..
		add_filter( 'wp_unique_post_slug', [ $this->app->get( Slug::class ), 'allow_duplicate_slugs' ], 10, 6 );

		// Update Reusable Blocks post type args and admin columns.
		add_filter( 'register_post_type_args', [ $this->app->get( Gutenberg::class ), 'reusable_block_update_post_type_args' ], 10, 2 );
		add_filter( 'manage_wp_block_posts_columns', [ $this->app->get( Gutenberg::class ), 'modify_wp_block_post_columns' ] );
		add_action( 'manage_wp_block_posts_custom_column', [ $this->app->get( Gutenberg::class ), 'add_wp_block_post_column_data' ], 10, 2 );
	}
}
