<?php
/**
 * BoldGrid Reseller API Client Basic Auth.
 *
 * @author Tim Elsass <dev@tim.ph>
 */

namespace Boldgrid\Api\Calls;

class Key extends Call {

	/**
	 * Gets the endpoint for these calls.
	 *
	 * @return string Endpoint to use for calls.
	 */
	public function getEndpoint() {
		return '/reseller/v2/key';
	}

	public function list( $dateFrom = '', $dateTo = '' ) {
		if ( $dateFrom && $dateTo ) {
			$opts = $dateFrom ? $opts['date_from'] = $dateFrom : $opts;
			$opts = $dateTo ? $opts['date_to'] = $dateTo : $opts;
			$this->setOptions(  );
		}

		return $this->getClient()->post( $this->getApiBaseUrl() . $this->getEndpoint() . '/' . __FUNCTION__ );
	}

	public function details( $connectId = '' ) {
		$opts['connect_id'] = $connectId;
		$this->setOptions( $opts );
		return $this->getClient()->post( $this->getApiBaseUrl() . $this->getEndpoint() . '/' . __FUNCTION__ );
	}

    public function create( $email, $isPremium ) {
		$opts = array();
		$opts = $email ? $opts['email'] = $email : $opts;
		$opts = $isPremium ? $opts['is_premium'] = $isPremium : $opts;
        $this->setOptions( $opts );
        return $this->getClient()->post( $this->getApiBaseUrl() . $this->getEndpoint() . '/' . __FUNCTION__ );
	}

	public function suspend( $connectId = '', $reason ) {
		$opts['connect_id'] = $connectId;
		$opts = $reason ? $opts['reason'] = $reason : $opts;
        $this->setOptions( $opts );
        return $this->getClient()->post( $this->getApiBaseUrl() . $this->getEndpoint() . '/' . __FUNCTION__ );
	}

	public function unsuspend( $connectId = '', $reason ) {
		$opts['connect_id'] = $connectId;
		$opts = $reason ? $opts['reason'] = $reason : $opts;
        $this->setOptions( $opts );
        return $this->getClient()->post( $this->getApiBaseUrl() . $this->getEndpoint() . '/' . __FUNCTION__ );
	}

	public function revoke( $connectId = '' ) {
		$opts['connect_id'] = $connectId;
        $this->setOptions( $opts );
        return $this->getClient()->post( $this->getApiBaseUrl() . $this->getEndpoint() . '/' . __FUNCTION__ );
	}

	public function changeType( $connectId = '', $type ) {
		$opts['connect_id'] = $connectId;
		$opts['type'] = $type;
        $this->setOptions( $opts );
        return $this->getClient()->post( $this->getApiBaseUrl() . $this->getEndpoint() . '/' . strtolower( __FUNCTION__ ) );
	}

	public function createReseller( $title = '', $email = '', $optional ) {
		$opts['title'] = $title;
		$opts['email'] = $email;
		$optional ? array_merge( $opts, $optional ) : $opts;
        $this->setOptions( $opts );
        return $this->getClient()->post( $this->getApiBaseUrl() . $this->getEndpoint() . '/' . strtolower( __FUNCTION__ ) );
	}
}
