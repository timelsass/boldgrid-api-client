<?php
/**
 * BoldGrid Reseller API Client Basic Auth.
 *
 * @author Tim Elsass <dev@tim.ph>
 */

namespace Boldgrid\Api\Calls;

use Boldgrid\Api\Curl;

use \Exception;
use \RuntimeException;

abstract class Call {

	private $options;
	private $client;

	/**
	 * @var Environment to run call in.
	 */
	private $environment;

	public function __construct( $environment, $args ) {
		$this->environment = $environment;
		$this->client = new Curl();

		if ( isset( $args['token'] ) ) {
			$this->client->setCustomHeader( array( 'Authorization: Bearer ' . $args['token'] ) );
		} elseif ( isset( $args['basic'] ) ) {
			$this->client->setCustomHeader( array( 'Authorization: Basic ' . $args['basic'] ) );
		} else {
			$this->setOptions( $args );
		}

		$this->init();
	}

	public function init(){}

	public function setOptions( $options = array() ) {
		$this->options = $options;
		$this->client->setPostParams( $this->options );

		return $this;
	}

	public function getOptions() {
		return $this->options;
	}

	public function setClient( $client ) {
		$this->client = $client;
	}

	public function getClient() {
		return $this->client;
	}

	public function getApiBaseUrl() {
		return $this->environment->getApiBaseUrl();
	}

	abstract public function getEndpoint();
}
