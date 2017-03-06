<?php
/**
 * BoldGrid Reseller API Client Basic Auth.
 *
 * @author Tim Elsass <dev@tim.ph>
 */

namespace Boldgrid\Reseller\Calls;

class Auth extends Call {

	/**
	 * Gets the endpoint for these calls.
	 *
	 * @return string Endpoint to use for calls.
	 */
	public function getEndpoint() {
		return '/reseller/v2/auth';
	}

	/**
	 * Retrieves a token from server.
	 *
	 * Gets an auth token from the BoldGrid Reseller
	 * API server based on the $key and $resellerKey
	 * credentials.
	 *
	 * @param string $key         BoldGrid Connect key for calls.
	 * @param string $resellerKey BoldGrid Reseller key for calls.
	 *
	 * @return Object The BoldGrid Reseller API's response.
	 */
	public function getToken( $key = '', $resellerKey = '' ) {
		$opts['key'] = $key;
		$opts['reseller_key'] = $resellerKey;
		$this->setOptions( $opts );
		return $this->getClient()->post( $this->getApiBaseUrl() . $this->getEndpoint() . '/' . strtolower( __FUNCTION__ ) );
	}
}
