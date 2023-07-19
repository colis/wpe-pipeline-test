<?php
/**
 * Wagner Spray Tech Digital River Admin Tables.
 *
 * @package WagnerSprayTechDigitalRiverIntegration\Admin
 */

namespace WagnerSprayTechDigitalRiverIntegration\Admin;

use League\Container\Container;
use League\Container\ReflectionContainer;
use WagnerSprayTechDigitalRiverIntegration\Data\Report;
use WP_List_Table;

/**
 * Digital River Admin Tables.
 */
class ReportTable extends WP_List_Table {

	/**
	 * App container object.
	 *
	 * @var Container $app
	 */
	protected Container $app;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->set_container();
		parent::__construct(
			[
				'singular' => __( 'Sync Report', 'wagner-spray-tech-digital-river-integration' ),     // singular name of the listed records.
				'plural'   => __( 'Sync Reports', 'wagner-spray-tech-digital-river-integration' ),   // plural name of the listed records.
				'ajax'     => false,        // does this table support ajax?
			]
		);
	}

	/**
	 * Display a no items message.
	 *
	 * @return void
	 */
	public function no_items() {
		esc_html_e( 'No Reports', 'wagner-spray-tech-digital-river-integration' );
	}

	/**
	 * Column header text.
	 *
	 * @param array|object $item item being displayed.
	 * @param string       $column_name current column name.
	 *
	 * @return mixed|string|void
	 */
	public function column_default( $item, $column_name ) {

		$rtn = '';

		switch ( $column_name ) {
			case 'post_id':
				$rtn = '<a href="' . get_edit_post_link( $item[ $column_name ] ) . '" target="_blank">' . get_the_title( $item[ $column_name ] ) . '</a>';
				break;
			default:
				$rtn = $item[ $column_name ];
				break;
		}

		return $rtn;
	}


	/**
	 *  Associative array of columns.
	 *
	 * @return array[]
	 */
	public function get_sortable_columns() {
		return [
			'type'        => [ 'type', false ],
			'last_update' => [ 'last_update', false ],
		];
	}

	/**
	 * Get the table columns.
	 *
	 * @return array
	 */
	public function get_columns() {
		return [
			'post_id'     => __( 'Product', 'wagner-spray-tech-digital-river-integration' ),
			'dr_id'       => __( 'Product ID', 'wagner-spray-tech-digital-river-integration' ),
			'type'        => __( 'Event', 'wagner-spray-tech-digital-river-integration' ),
			'last_update' => __( 'Date', 'wagner-spray-tech-digital-river-integration' ),
			'change_log'  => __( 'Log', 'wagner-spray-tech-digital-river-integration' ),
		];
	}


	/**
	 * Get the table data.
	 *
	 * @return $this|void
	 */
	public function prepare_items() {

		$columns               = $this->get_columns();
		$hidden                = [];
		$sortable              = $this->get_sortable_columns();
		$this->_column_headers = [ $columns, $hidden, $sortable ];
		$this->items           = $this->app->get( Report::class )->get_results();

		return $this;
	}


	/**
	 * Create  the Container object.
	 *
	 * @return void
	 */
	protected function set_container(): void {
		$this->app = new Container();
		$this->app->delegate(
			new ReflectionContainer( true )
		);
	}
}
