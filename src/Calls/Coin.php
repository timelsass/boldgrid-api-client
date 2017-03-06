<?php
/**
 * BoldGrid Reseller API Client Basic Auth.
 *
 * @author Tim Elsass <dev@tim.ph>
 */

namespace Boldgrid\Reseller\Calls;

class Coin extends Call {

	/**
	 * Gets the endpoint for these calls.
	 *
	 * @return string Endpoint to use for calls.
	 */
	public function getEndpoint() {
		return '/reseller/v2/coin';
	}

	public function balance( $connectId = '' ) {
		$opts['connect_id'] = $connectId;
		$this->setOptions( $opts );
		return $this->getClient()->post( $this->getApiBaseUrl() . $this->getEndpoint() . '/' . __FUNCTION__ );
	}

	public function add( $connectId = '', $coins = '' ) {
		$opts['connect_id'] = $connectId;
		$opts['coins'] = $coins;
		$this->setOptions( $opts );
		return $this->getClient()->post( $this->getApiBaseUrl() . $this->getEndpoint() . '/' . __FUNCTION__ );
	}

	public function remove( $connectId = '', $coins = '' ) {
		$opts['connect_id'] = $connectId;
		$opts['coins'] = $coins;
		$this->setOptions( $opts );
		return $this->getClient()->post( $this->getApiBaseUrl() . $this->getEndpoint() . '/' . __FUNCTION__ );
	}
}
