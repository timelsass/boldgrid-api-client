<?php
/**
 * BoldGrid Reseller API Client Sandbox Environment.
 *
 * @author Tim Elsass <dev@tim.ph>
 */

namespace Boldgrid\Api\Environment;

use Boldgrid\Api\Environment\Environment;

/**
 * Sets up the required paramenters for the Sandbox
 * enviroment for the BoldGrid Reseller API.
 */
class Sandbox implements Environment {

	/**
	 * Retrieves the Sandbox Environment's
	 * base URL.
	 *
	 * @return string Base URL to use for API calls.
	 */
	public function getApiBaseUrl() {
		return 'https://api-sandbox.boldgrid.com';
	}
}
