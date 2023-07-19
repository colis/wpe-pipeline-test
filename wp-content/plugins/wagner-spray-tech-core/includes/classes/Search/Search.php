<?php
/**
 * Search related functionalities.
 *
 * @package WagnerSprayTechCore\Search
 */

namespace WagnerSprayTechCore\Search;

use WagnerSprayTechCore\BaseAbstract;

/**
 * Class Search
 *
 * @package WagnerSprayTechCore
 */
class Search extends BaseAbstract {

	/**
	 * Redirect default site search to Search & Filter Pro search results page.
	 */
	public function default_search_url_rewrite() {
		if ( \is_search() ) {
			\wp_safe_redirect( \home_url( 'search/?_sf_s=' ) . rawurlencode( \get_query_var( 's' ) ) );
		}
	}
}
