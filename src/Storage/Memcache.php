<?php
/**
 * BoldGrid Reseller API Client Memcache Storage.
 *
 * @author Tim Elsass <dev@tim.ph>
 */

namespace Boldgrid\Reseller\Storage;

use Boldgrid\Reseller\Storage\Storage;

/**
 * Gets and sets data from memcache storage.
 */
class Memcache implements Storage {

	/**
	 * @var $memcache Holds our instance of the memcache object.
	 * @var $tokenKey The key we will retrieve the token from.
	 * @var $expirationKey The key we will retrieve the expire time from.
	 */
	protected
		$memcache,
		$tokenKey = 'BGResellerToken',
		$expirationKey = 'BGResellerExpiration';

	/**
	 * Initialize class and set class propeties.
	 *
	 * @throws RuntimeException If memcache is not accessible, an exception is thrown.
	 *
	 * @return null
	 */
	public function __construct() {
		if ( ! $this->open() ) throw new \RuntimeException( 'Memcache is not enabled, or able to be written to.' );
	}

	/**
	 * The method is used to open the connection to storage.
	 *
	 * @return bool Can memcache open/read/write?
	 */
	public function open() {
		if ( class_exists( 'Memcache' ) ) {
			$server = 'localhost';

			if ( ! empty( $_REQUEST['server'] ) ) {
				$server = $_REQUEST['server'];
			}

			$memcache = new \Memcache;
			$isMemcacheAvailable = @$memcache->connect( $server );

			if ( $isMemcacheAvailable ) {
				$data = $memcache->get( 'data' );
				// Check if data is already in storage or set new test data.
				if ( ! $data ) {
					$new = array(
						'test' => 'memcache storage',
					);

					$memcache->set( 'data', $new, 0, 300 );
				}

				$data = $memcache->get( 'data' );

				if ( $data ) {
					$memcache->delete( 'data' );
					$this->memcache = $memcache;
					return true;
				}
			}
		}

		return false;
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
		$this->memcache->set( $key, $value, 0, 172440 );
	}

	/**
	 * Gets the specified key's data.
	 *
	 * @param  string $key The key to retrieve from storage.
	 *
	 * @return mixed The key's data.
	 */
	public function get( $key ) {
		$data = $this->memcache->get( $key );

		if ( ! $data ) {
			return false;
		}

		return $data;
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
		$this->memcache->close();
	}
}
