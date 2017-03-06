<?php
/**
 * BoldGrid Reseller API Client Production Environment.
 *
 * @author Tim Elsass <dev@tim.ph>
 */

namespace Boldgrid\Reseller\Environment;

use Boldgrid\Reseller\Environment\Environment;

/**
 * Sets up the required paramenters for the production
 * enviroment for the BoldGrid Reseller API.
 */
class Production implements Environment {

	/**
	 * Retrieves the Production Environment's base URL.
	 *
	 * @return string Base URL to use for API calls.
	 */
	public function getApiBaseUrl() {
		return 'https://api.boldgrid.com';
	}
}
