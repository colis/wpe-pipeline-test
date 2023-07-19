<?php
/**
 * Wagner Spray Tech Core Plugin Base
 *
 * @package WagnerSprayTechCore
 */

namespace WagnerSprayTechCore;

use League\Container\Container;
use League\Container\ReflectionContainer;

/**
 * Wagner Spray Tech Core Plugin Base
 *
 * @package WagnerSprayTechCore
 */
abstract class BaseAbstract {

	/**
	 * App container object.
	 *
	 * @var Container $app
	 */
	protected Container $app;

	/**
	 * Either inject an already constructed container or create a new on when object is instantiated
	 */
	public function __construct() {
		$this->set_container();
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
