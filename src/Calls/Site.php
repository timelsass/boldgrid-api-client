<?php
/**
 * BoldGrid Reseller API Client Basic Auth.
 *
 * @author Tim Elsass <dev@tim.ph>
 */

namespace Boldgrid\Reseller\Calls;

class Site extends Call {

	/**
	 * Gets the endpoint for these calls.
	 *
	 * @return string Endpoint to use for calls.
	 */
	public function getEndpoint() {
		return '/reseller/v2/site';
	}

	public function list( $connectId = '', $dateFrom, $dateTo ) {
		$opts['connect_id'] = $connectId;
		$opts = $dateFrom ? $opts['date_from'] = $dateFrom : $opts;
		$opts = $dateTo ? $opts['date_to'] = $dateTo : $opts;
		$this->setOptions( $opts );
		return $this->getClient()->post( $this->getApiBaseUrl() . $this->getEndpoint() . '/' . __FUNCTION__ );
	}
}
