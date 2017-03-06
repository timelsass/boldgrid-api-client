<?php
/**
 * BoldGrid Reseller API Client Basic Auth.
 *
 * @author Tim Elsass <dev@tim.ph>
 */

namespace Boldgrid\Reseller\Calls;

class User extends Call {

	/**
	 * Gets the endpoint for these calls.
	 *
	 * @return string Endpoint to use for calls.
	 */
	public function getEndpoint() {
		return '/reseller/v2/user';
	}

	public function update( $connectId = '', $email, $displayName ) {
		$opts['connect_id'] = $connectId;
		$opts = $email ? $opts['email'] = $email : $opts;
		$opts = $displayName ? $opts['display_name'] = $displayName : $opts;
		$this->setOptions( $opts );
		return $this->getClient()->post( $this->getApiBaseUrl() . $this->getEndpoint() . '/' . __FUNCTION__ );
	}

	public function updateReseller( $title = '', $email = '', $optional ) {
		$opts['title'] = $title;
		$opts['email'] = $email;
		$optional ? array_merge( $opts, $optional ) : $opts;
		$this->setOptions( $opts );
		return $this->getClient()->post( $this->getApiBaseUrl() . $this->getEndpoint() . '/' . strtolower( __FUNCTION__ ) );
	}
}
