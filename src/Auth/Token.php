<?php
/**
 * BoldGrid Reseller API Client Token Auth.
 *
 * @author Tim Elsass <dev@tim.ph>
 */

namespace Boldgrid\Api\Auth;

use Boldgrid\Api\Boldgrid;
use Boldgrid\Api\Environment\Environment;

/**
 * Token based authorization for the BoldGrid
 * Reseller API.
 */
class Token {

	/**
	 * @var $environment Environment object to make our call to for the token.
	 * @var $token The auth token.
	 * @var $expiration The expiration time of the auth token.
	 * @var $key The BoldGrid Connect key.
	 * @var $resellerKey The BoldGrid Reseller Key.
	 */
	protected
		$environment,
		$token,
		$expiration,
		$key,
		$resellerKey;

	/**
	 * Initializes Class and sets properties.
	 *
	 * @return null
	 */
	public function __construct( Environment $environment, $key, $resellerKey ) {
		$this->environment = $environment;
		$this->resellerKey = $resellerKey;
		$this->key = $key;
		$this->setToken();
		$this->setExpiration();
	}

	/**
	 * Makes call for BoldGrid Reseller API authorization token.
	 *
	 * @return null
	 */
	public function call() {
		$api = new Boldgrid( $this->environment );
		$response =
			$api->setAuth( 'key' )
				->auth()
				->getToken( $this->key, $this->resellerKey );

		return $response;
	}

	/**
	 * Sets the token from the API call made.
	 *
	 * @return self
	 */
	private function setToken() {
		$response = $this->call();
		return $this->token = $response->result->data->token;
	}

	/**
	 * Gets the token from the API call made.
	 *
	 * @return string $token The auth token to use for requests.
	 */
	public function getToken() {
		return $this->token;
	}

	/**
	 * Sets the expiration time that is stored in the token reponse.
	 *
	 * @return self
	 */
	private function setExpiration() {
		list( $headers, $body, $secret ) = explode( '.', $this->token );
		$body = json_decode( base64_decode( $body ) );
		return $this->expiration = $body->exp;
	}

	/**
	 * Gets the expiration time of the token from the API call made.
	 *
	 * @return int $expiration Unix time of expiration for token.
	 */
	public function getExpiration() {
		return $this->expiration;
	}
}
