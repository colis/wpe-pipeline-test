<?php
/**
 * Wagner Spray Tech Digital River Sync Settings Options Page.
 *
 * @package WagnerSprayTechDigitalRiverIntegration\Settings
 */

namespace WagnerSprayTechDigitalRiverIntegration\Settings;

use GuzzleHttp\Exception\GuzzleException;
use WagnerSprayTechDigitalRiverIntegration\Admin\Form;
use WagnerSprayTechDigitalRiverIntegration\Admin\ReportTable;
use WagnerSprayTechDigitalRiverIntegration\Data\Product;

/**
 * Wagner Spray Tech Digital River Sync Settings Options Page.
 *
 * @package WagnerSprayTechDigitalRiverIntegration\Settings
 */
class Sync extends OptionsPageAbstract {

	/**
	 * Options page name.
	 *
	 * @var string
	 */
	public string $options_name = 'Digital River Sync';


	/**
	 * Form action string.
	 *
	 * @var string
	 */
	private array $form_actions = [ 'digital_river_sync', 'digital_river_sync_update_wp' ];





	/**
	 * Render the page
	 */
	public function render(): void {

		echo '<div class="wrap">';
		echo sprintf( '<h1>%s</h1>', esc_html( 'Digital River Sync' ) );

		$form_class_name = $this->form_actions[0] . '_manual_sync';

		// Manual Sync Form.
		$this->app->get( Form::class )->render(
			settings_name: $this->form_actions[0],
			text: 'Action a manual product sync',
			submit_button_text: 'Sync all Products',
			action: admin_url( 'admin-post.php' ),
			form_fields: [
				[
					'name'          => 'task',
					'type'          => 'hidden',
					'label'         => '',
					'tag'           => 'input',
					'default_value' => 'init',
				],
				[
					'name'          => 'page',
					'type'          => 'hidden',
					'label'         => '',
					'tag'           => 'input',
					'default_value' => 0,
				],
			],
			method: 'post',
			class_name: $form_class_name
		);

		$this->app->get( ReportTable::class )->prepare_items()->display();

		echo '</div>';
	}


	/**
	 * Start syncing the products and categories.
	 *
	 * @return string
	 * @throws GuzzleException Guzzle Exception.
	 * @throws \JsonException Json Exception.
	 */
	public function process(): void {

		$data = [];

		//phpcs:ignore
		if ( ! wp_verify_nonce( wp_unslash( $_POST[ $this->form_actions[0] . '_nonce' ] ), $this->form_actions[0] . '_nonce' ) ) {
			return;
		}
		// phpcs:ignore
		if ( ! isset( $_POST['action'] ) ) {
			return;
		}
		// phpcs:ignore
		if ( ! in_array( $_POST['action'], $this->form_actions, true ) ) {
			return;
		}
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		$task = wp_unslash( $_POST['task'] ) ?? ''; // phpcs:ignore
		$page   = absint( wp_unslash( $_POST['page'] ) ); //phpcs:ignore

		switch ( $task ) {

			case 'init':
				// get the total pages to sync, save as a transient.
				$data = $this->app->get( Product::class )->get_totals();
				$this->set_option( sprintf( '%stotals', $this->app->get( Product::class )->site_option_name ), $data );
				break;

			case 'download':
				// store this in a site option per page.
				$page_data = $this->app->get( Product::class )->get_page( $page, true );
				$this->set_option( sprintf( '%spage_%s', $this->app->get( Product::class )->site_option_name, $page ), $page_data );
				$data = [
					'page' => $page,
					'task' => 'Downloading from Digital River...',
				];
				break;

			case 'update':
				// update WordPress with the data.
				$this->app->get( Product::class )->update_page( $page );
				$data = [
					'page' => $page,
					'task' => 'Updating WordPress...',
				];
				break;

			case 'complete':
				// Delete the site options.
				delete_option( sprintf( '%stotals', $this->app->get( Product::class )->site_option_name ) );
				$data = [
					'task' => 'All Done!',
					'page' => 'complete',
				];
				break;

		}

		echo json_encode( $data, JSON_THROW_ON_ERROR );
		wp_die();
	}

	/**
	 * Configure the admin page.
	 *
	 * @return void
	 */
	public function configure(): void {
		\register_setting( $this->get_menu_slug(), $this->options_name );
	}

	/**
	 * Get the menu slug.
	 *
	 * @return string
	 */
	protected function get_menu_slug(): string {
		return 'digital-river-sync';
	}

	/**
	 * Get the page title.
	 *
	 * @return string
	 */
	protected function get_page_title(): string {
		return __( 'Digital River Sync', 'wagner-spray-tech-digital-river-integration' );
	}

	/**
	 * Get the position in the menu order this item should appear.
	 *
	 * @return int
	 */
	protected function get_menu_position(): int {
		return 10;
	}

	/**
	 * Get the icon of the options page.
	 *
	 * @return string
	 */
	protected function get_menu_icon(): string {
		return 'dashicons-image-rotate';
	}
}
