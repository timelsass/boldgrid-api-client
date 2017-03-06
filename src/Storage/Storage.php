<?php
/**
 * BoldGrid Reseller API Client Storage Interface.
 *
 * @author Tim Elsass <dev@tim.ph>
 */

namespace Boldgrid\Reseller\Storage;

/**
 * Describes how to get and set items from storage.
 */
interface Storage {

	/**
	 * Class initialization must open the connection to storage.
	 */
	function __construct();

	/**
	 * The method is used to open the connection to storage.
	 */
	function open();

	/**
	 * Sets key with specified value.
	 *
	 * @param string $key   Key to access.
	 * @param string $value The value to set for the key.
	 *
	 * @return null This method should not return any data.
	 */
	function set( $key, $value );

	/**
	 * Gets the specified key's data.
	 *
	 * @param  string $key The key to retrieve from storage.
	 *
	 * @return mixed The key's data.
	 */
	function get( $key );

	/**
	 * This method is used to get the key name for the token
	 * in storage.
	 *
	 * @return string The name of the key for the token in storage.
	 */
	function getTokenKey();

	/**
	 * This method is used to get the key name for the expire time
	 * in storage.
	 *
	 * @return string The name of the key for the expire time in storage.
	 */
	function getExpirationKey();

	/**
	 * The method is used to close the connection to storage.
	 *
	 * @return null This method should not return any data.
	 */
	function close();
}
