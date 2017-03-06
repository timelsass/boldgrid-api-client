<?php
/**
 * BoldGrid Reseller API PHP Client.
 *
 * This client is intended to be used to make calls to
 * and from the BoldGrid Reseller API.  You can reference
 * the API documentation for further details and usage.
 *
 * @link https://boldgrid.com/docs/api
 *
 * @author Tim Elsass <dev@tim.ph>
 */

namespace Boldgrid\Reseller;

use Boldgrid\Reseller\Environment\Environment;
use Boldgrid\Reseller\Environment\Production;

use Boldgrid\Reseller\Storage\Storage;
use Boldgrid\Reseller\Storage\Session;

use Boldgrid\Reseller\Auth;

/**
 * Kicks off BoldGrid Reseller API requests.
 */
class Boldgrid {

	/**
	 * @var environment Environment to use.
	 * @var $auth Authentication type to use.
	 * @var $storage Storage type to use.
	 * @var $key Boldgrid Connect Key.
	 * @var $resellerKey BoldGrid Reseller Key.
	 */
	protected
		$environment,
		$auth = 'token',
		$storage,
		$key,
		$resellerKey;

	/**
	 * Initialize class and set properties.
	 *
	 * @return null
	 */
	public function __construct( Environment $environment = null, Storage $type = null ) {
		$this->environment = $this->getEnvironment( $environment );
		$this->storage = $this->getStorage( $type );
	}

	/**
	 * Gets the environment to use for API calls.
	 *
	 * This is defaulting to Production, but you can pass in
	 * a new instance of Sandbox or Development as the parameter
	 * to utilize alternative Reseller API environments.
	 *
	 * @param  Environment $environment Sets the API environment.
	 *
	 * @return Environment              Class implementing Environment interface.
	 */
	public function getEnvironment( Environment $environment = null ) {
		return ( ! $environment ) ? new Production() : $environment;
	}

	/**
	 * Gets the BoldGrid Connect Key parameter.
	 *
	 * @return string $key A BoldGrid Connect Key.
	 */
	public function getKey() {
		return $this->key;
	}

	/**
	 * Gets the BoldGrid Reseller Key parameter.
	 *
	 * @return string $resellerKey A BoldGrid Reseller Key.
	 */
	public function getResellerKey() {
		return $this->$resellerKey;
	}

	/**
	 * Gets the BoldGrid Connect Authorization Type.
	 *
	 * @return string $auth Authentication type to use.
	 */
	public function getAuth() {
		return $this->auth;
	}

	/**
	 * Gets the environment to use for API calls.
	 *
	 * This is defaulting to Production, but you can pass in
	 * new Sandbox() as the parameter to utilize the Reseller
	 * Sandbox API.
	 *
	 * @param  Environment $environment Sets the API environment.
	 *
	 * @return Environment              Class implementing Environment interface.
	 */
	public function getStorage( Storage $type = null ) {
		return ( ! $type ) ? new Session() : $type;
	}

	/**
	 * Gets the Token from session storage if available.
	 * If not it will call for a new auth token to be generated.
	 *
	 * @param  Storage $storage Storage interface.
	 * @return [type]           [description]
	 */
	public function getStorageToken( Storage $storage ) {
		$tokenKey = $storage->getTokenKey();
		$token = $storage->get( $tokenKey );
		$expirationKey = $storage->getExpirationKey();
		$expiration = $storage->get( $expirationKey );

		// No token, no expiration, or expiration is past now.
		if ( ! $token || ! $expiration || time() > $expiration ) {
			$token = new Auth\Token( $this->environment, $this->key, $this->resellerKey );
			$storage->set( $tokenKey, $token->getToken() );
			$expiration = $token->getExpiration();
			$storage->set( $expirationKey, $expiration );
			$token = $storage->get( $tokenKey );
		}

		$storage->close();

		return $token;
	}

	/**
	 * Checks the auth type being used and returns then
	 * required arguments needed for the API request.
	 *
	 * @param  array  $args Arguments for API call.
	 *
	 * @return array  $args Arguments for API call.
	 */
	public function callType( array $args = array() ) {
		if ( $this->getAuth() === 'token' ) {
			$args['token'] = $this->getStorageToken( $this->storage );
		} elseif ( $this->getAuth() === 'basic' ) {
			$basic = new Auth\Basic( $this->key, $this->resellerKey );
			$args['basic'] = $basic->getBasic();
		} else {
			$args['key'] = $this->key;
			$args['reseller_key'] = $this->resellerKey;
		}

		return $args;
	}

	/**
	 * Allows users to set the Environment for API calls.
	 *
	 * @param Environment $environment Class that implements Environment interface.
	 *
	 * @return object $this Returns self for method chaining.
	 */
	public function setEnvironment( Environment $environment ) {
		$this->environment = $environment;
		return $this;
	}

	/**
	 * Allows users to set the BoldGrid Connect Key parameter.
	 *
	 * @param string $key A BoldGrid Connect Key.
	 *
	 * @return object $this Returns self for method chaining.
	 */
	public function setAuth( $type ) {
		$this->auth = strtolower( $type );
		return $this;
	}

	/**
	 * Allows users to set the BoldGrid Connect Key parameter.
	 *
	 * @param string $key A BoldGrid Connect Key.
	 *
	 * @return object $this Returns self for method chaining.
	 */
	public function setKey( $key ) {
		$this->key = $key;
		return $this;
	}

	/**
	 * Allows users to set the BoldGrid Reseller Key parameter.
	 *
	 * @param string $resellerKey A BoldGrid Reseller Key.
	 *
	 * @return object $this Returns self for method chaining.
	 */
	public function setResellerKey( $resellerKey ) {
		$this->resellerKey = $resellerKey;
		return $this;
	}

	/**
	 * Allows users to set the storage type for token and data.
	 *
	 * @param Storage $type Class implementing storage interface.
	 *
	 * @return object $this Returns self for method chaining.
	 */
	public function setStorage( Storage $type ) {
		$this->storage = $type;
		return $this;
	}

	/**
	 * Calls for the API endpoints are routed to classes with
	 * PHP magic.
	 *
	 * @param  string $name Endpoint being called.
	 * @param  array  $args Optional arguments to pass to endpoints.
	 *
	 * @return object $class Class to instantiate.
	 */
	public function __call( $name, array $args = array() ) {
		$args = array_merge( $args, $this->calltype() );

		$className = __NAMESPACE__ . '\\Calls\\' . ucfirst( $name );

		if ( ! class_exists( $className ) ) {
			throw new \InvalidArgumentException( $name . ' is an invalid BoldGrid Connect API endpoint!' );
		}

		$class = new $className( $this->environment, $args );

		return $class;
	}
}
