<?php
/**
 * Wagner Spray Tech Digital River Integration Reporting Functionality
 *
 * @package WagnerSprayTechDigitalRiverIntegration\Data
 */

namespace WagnerSprayTechDigitalRiverIntegration\Data;

use WagnerSprayTechCore\BaseAbstract;


/**
 * Report changes to a custom table.
 */
class Report extends BaseAbstract {


	/**
	 * Custom table name.
	 *
	 * @var string
	 */
	private string $custom_table_name = 'wp_wst_dr_sync';


	/**
	 * Valid Report Types.
	 *
	 * @var array|string[]
	 */
	public array $type_collection = [
		'create' => 'Create',
		'update' => 'Update',
		'delete' => 'Delete',
	];


	/**
	 * Return latest 10,000 results.
	 *
	 * @return array
	 */
	public function get_results(): array {

		global $wpdb;
		return $wpdb->get_results( "SELECT * FROM $this->custom_table_name ORDER BY last_update DESC LIMIT 0, 10000", ARRAY_A ); //phpcs:ignore
	}


	/**
	 * Create a report line.
	 *
	 * @param int    $post_id Post ID.
	 * @param int    $dr_id Digital River ID.
	 * @param string $attribute Attribute name.
	 * @param string $type Type of change.
	 * @param string $change_log Change log.
	 *
	 * @return void
	 */
	public function create( int $post_id, int $dr_id, string $attribute, string $type, string $change_log ): void {
		global $wpdb;

		$insert_query = <<<SQL
			INSERT IGNORE INTO {$this->custom_table_name} (post_id, dr_id, attribute, type, change_log)
			VALUES (%d, %d, %s, %s, %s)
		SQL;

		$wpdb->query( $wpdb->prepare( $insert_query, $post_id, $dr_id, $attribute, $type, $change_log ) ); // phpcs:ignore
	}


	/**
	 * Create a custom reporting table.
	 *
	 * @return void
	 */
	public function create_custom_table(): void {

		if ( $this->does_custom_table_exist() ) {
			return;
		}

		global $wpdb;

		$create_table_query = <<<SQL
				CREATE TABLE {$this->custom_table_name}
				(
				    id          int auto_increment primary key,
				    post_id     int                                  not null,
				    dr_id       int                                  not null,
				    attribute   varchar(255)                         not null,
				    type        varchar(255)                         not null,
				    change_log  text                                 null,
				    last_update datetime default current_timestamp() not null on update current_timestamp()
				);
				SQL;

		$create_index_query = <<<SQL
				CREATE INDEX `attributes` ON {$this->custom_table_name} (post_id, dr_id, type, attribute, last_update);
				SQL;

		$wpdb->query( $create_table_query ); // phpcs:ignore
		$wpdb->query( $create_index_query ); // phpcs:ignore
	}


	/**
	 * Does the custom table exist for this plugin.
	 *
	 * @return bool
	 */
	public function does_custom_table_exist(): bool {

		global $wpdb;

		$check_query = <<<SQL
				SHOW TABLES LIKE %s
			SQL;

		// phpcs:ignore
		if ( $this->custom_table_name === $wpdb->get_var( $wpdb->prepare( $check_query, $wpdb->esc_like( $this->custom_table_name ) ) ) ) {
			return true;
		}

		return false;
	}
}
