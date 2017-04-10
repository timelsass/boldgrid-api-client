<?php
/**
 * BoldGrid Reseller API Client Development Environment.
 *
 * @author Tim Elsass <dev@tim.ph>
 */

namespace Boldgrid\Api\Environment;

use Boldgrid\Api\Environment\Environment;

/**
 * Sets up the required paramenters for the development
 * enviroment for the BoldGrid Reseller API.
 */
class Development implements Environment {

	/**
	 * Retrieves the Development Environment's
	 * base URL.
	 *
	 * @return string Base URL to use for API calls.
	 */
	public function getApiBaseUrl() {
		return 'https://api-dev.boldgrid.com';
	}
}
