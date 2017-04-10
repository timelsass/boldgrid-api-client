<?php
/**
 * BoldGrid Reseller API Client Session Storage.
 *
 * @author Tim Elsass <dev@tim.ph>
 */

namespace Boldgrid\Api\Storage;

use Boldgrid\Api\Storage\Storage;

/**
 * This contains the logic for retrieving and setting
 * keys/values in session storage.
 */
class Session implements Storage {

	/**
	 * @var $tokenKey The key we will retrieve the token from.
	 * @var $expirationKey The key we will retrieve the expire time from.
	 */
	protected
		$tokenKey = 'BGResellerToken',
		$expirationKey = 'BGResellerExpiration';

	/**
	 * Initialize class and set class propeties.
	 *
	 * @return null
	 */
	public function __construct() {
		$this->open();
	}

	/**
	 * The method is used to open the connection to storage.
	 *
	 * @return null
	 */
	public function open() {
		$status = session_id() !== '';

		if ( version_compare( PHP_VERSION, '5.4.0', '>=' ) ) {
			$status = session_status() !== PHP_SESSION_NONE;
		}

		! $status && session_start();
	}

	/**
	 * Sets key with specified value.
	 *
	 * @param string $key   Key to access.
	 * @param string $value The value to set for the key.
	 *
	 * @return null This method should not return any data.
	 */
	public function set( $key, $value ) {
		$_SESSION[$key] = $value;
	}

	/**
	 * Gets the specified key's data.
	 *
	 * @param  string $key The key to retrieve from storage.
	 *
	 * @return mixed The key's data.
	 */
	public function get( $key ) {
		if ( ! isset( $_SESSION[$key] ) || empty( $_SESSION[$key] ) ) {
			return false;
		}

		return $_SESSION[$key];
	}

	/**
	 * This method is used to get the key name for the token
	 * in storage.
	 *
	 * @return string The name of the key for the token in storage.
	 */
	public function getTokenKey() {
		return $this->tokenKey;
	}

	/**
	 * This method is used to get the key name for the expire time
	 * in storage.
	 *
	 * @return string The name of the key for the expire time in storage.
	 */
	public function getExpirationKey() {
		return $this->expirationKey;
	}

	/**
	 * The method is used to close the connection to storage.
	 *
	 * @return null This method should not return any data.
	 */
	public function close() {
		session_write_close();
	}
}
