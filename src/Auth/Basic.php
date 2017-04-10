<?php
/**
 * BoldGrid Reseller API Client Basic Auth.
 *
 * @author Tim Elsass <dev@tim.ph>
 */

namespace Boldgrid\Api\Auth;

/**
 * Basic authorization for BoldGrid Reseller API.
 */
class Basic {

	/**
	 * @var $basic The auth string for header.
	 * @var $key The BoldGrid Connect key.
	 * @var $resellerKey The BoldGrid Reseller Key.
	 */
	protected
		$basic,
		$key,
		$resellerKey;

	/**
	 * Initialize and set class properties.
	 *
	 * @param string $key         BoldGrid Connect key for calls.
	 * @param string $resellerKey BoldGrid Reseller key for calls.
	 */
	public function __construct( $key, $resellerKey ) {
		$this->key = $key;
		$this->resellerKey = $resellerKey;
		$this->basic = $this->setBasic( $this->key, $this->resellerKey );
	}

	/**
	 * Sets the basic authorization encoding.
	 *
	 * This is the basic authorization encoding used
	 * for the BoldGrid Reseller API calls.  This is
	 * the same implementation as standard basic auth
	 * where $key:$resellerKey is user:password and
	 * then base64 encoded for clarification.
	 *
	 * @param string $key         BoldGrid Connect key for calls.
	 * @param string $resellerKey BoldGrid Reseller key for calls.
	 *
	 * @return Auth\Basic Sets $basic on self.
	 */
	protected function setBasic( $key, $resellerKey ) {
		return $this->basic = base64_encode( $key . ':' . $resellerKey );
	}

	/**
	 * Retrieves the basic auth encoded string.
	 *
	 * @return string $basic The base64 encoded string for header.
	 */
	public function getBasic() {
		return $this->basic;
	}
}
