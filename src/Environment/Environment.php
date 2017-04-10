<?php
/**
 * BoldGrid Reseller API Client Storage Interface.
 *
 * @author Tim Elsass <dev@tim.ph>
 */

namespace Boldgrid\Api\Environment;

/**
 * Describes how to implement new environments
 * for BoldGrid Reseller API calls.
 */
interface Environment {

	/**
	 * Retrieves the API base URL for calls.
	 *
	 * @return string Base URL to use for API calls.
	 */
	function getApiBaseUrl();
}
