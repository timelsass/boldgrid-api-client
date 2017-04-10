<?php
/**
 * BoldGrid Reseller API Client Basic Auth.
 *
 * @author Tim Elsass <dev@tim.ph>
 */

namespace Boldgrid\Api;

/**
 * Make cURL calls for API requests.
 */
class Curl {

	/**
	 * @var $_postParams POST parameters to pass for call.
	 * @var $_ch Reference to the cURL handle.
	 */
	private
		$_postParams,
		$_ch;

	/**
	 * Initialize and set class properties.
	 *
	 * @throws Exception If cURL is not able to be initialized.
	 *
	 * @return null
	 */
	public function __construct() {
		try {
			$this->_ch = curl_init();
		} catch ( \Exception $e ) {
			throw new \Exception( 'Unable to initialize cURL, make sure that it is enabled.' );
		}

		$this->setCurlOptions();
	}

	/**
	 * Sets the default cURL options we will be using
	 * for all of our calls.
	 *
	 * @return null
	 */
	private function setCurlOptions() {
		curl_setopt( $this->_ch, CURLOPT_POST, 1 );
		curl_setopt( $this->_ch, CURLOPT_RETURNTRANSFER, true );
	}

	/**
	 * Sets any custom headers we need to pass for cURL.
	 *
	 * @param array $headers Any custom headers to pass in.
	 *
	 * @return null
	 */
	public function setCustomHeader( $headers ) {
		curl_setopt( $this->_ch, CURLOPT_HTTPHEADER, $headers );
	}

	/**
	 * Sets POST parameters for our cURL calls.
	 *
	 * @param array $params Post parameters for calls.
	 *
	 * @return null
	 */
	public function setPostParams( $params ) {
		$this->_postParams = $params;
		curl_setopt( $this->_ch, CURLOPT_POSTFIELDS, $this->_postParams );
	}

	/**
	 * Makes a POST request with cURL.
	 *
	 * @param  string $url URL to use for call.
	 *
	 * @return Object $response The response of the call if it's able to be made.
	 */
	public function post( $url ) {
		curl_setopt( $this->_ch, CURLOPT_URL, $url );
		$response = $this->exec();
		return $this->checkResponse( $response );
	}

	/**
	 * Executes the cURL request after our params are set.
	 *
	 * @throws RuntimeException If there was an issue executing call.
	 *
	 * @return Object $response The response of the cURL call.
	 */
	public function exec() {
		$response = curl_exec( $this->_ch );
		if ( curl_error( $this->_ch ) ) {
			throw new \RuntimeException(
				'Error communicating with the BoldGrid Connect API: ' . curl_error( $this->_ch )
			);
		}

		return $response;
	}

	/**
	 * Checks that response is valid or throw an exception.
	 *
	 * @param Object $response The response from the API call.
	 *
	 * @return Object $response The response from the API call.
	 */
	public function checkResponse( $response ) {
		$httpStatus = curl_getinfo( $this->_ch, CURLINFO_HTTP_CODE );
		$response = json_decode( $response );

		if ( $httpStatus !== 200 ) {
			throw new \Exception(
				'BoldGrid Connect API Error! Status Code ' .
				$response->{'status'} . ': ' . $response->{'message'}
			);
		}

		return $response;
	}

	/**
	 * Closes the cURL connection when we are through.
	 *
	 * @return null
	 */
	public function __destruct() {
		curl_close( $this->_ch );
	}
}
