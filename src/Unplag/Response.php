<?php
/**
 * Created by IntelliJ IDEA.
 * User: egormelnikov
 * Date: 12.03.16
 * Time: 15:09
 */

namespace Unplag;


use Psr\Http\Message\ResponseInterface;
use Unplag\Exception\UnexpectedResponseException;

class Response
{
	const ACCEPT_MIME = 'application/x-msgpack';

	protected $_guzzle_resp;
	protected $_data;

	public function __construct(ResponseInterface $guzzle_response)
	{
		if($guzzle_response->getHeaderLine('Content-Type') !== static::ACCEPT_MIME) {
			throw new \InvalidArgumentException("Invalid content type received from Unplag API");
		}

		$unpacker = new \MessagePack\Unpacker();
		$this->_data = $unpacker->unpack($guzzle_response->getBody()->getContents());
		$this->_guzzle_resp = $guzzle_response;
	}

	public function getData() {
		return $this->_data;
	}

	/**
	 * @return ResponseInterface
	 */
	public function getGuzzleResponse() {
		return $this->_guzzle_resp;
	}

	public function getStatusCode() {
		return $this->getGuzzleResponse()->getStatusCode();
	}

	public function getDataProperty($key) {
		return isset($this->getData()[$key]) ? $this->getData()[$key] : null;
	}

	public function isSuccess() {
		return $this->getStatusCode() === 200 && $this->getDataProperty('result') === true;
	}

	public function __debugInfo()
	{
		return [
			'code' => $this->getStatusCode(),
		    'data' => $this->getData()
		];
	}

	public function __toString()
	{
		ob_start();
		var_dump($this);
		return 'Unplag\Response: ' . ob_get_clean();
	}

	public function getExpectedDataProperty($key) {
		$propData = $this->getDataProperty($key);
		if(!$propData) {
			throw new UnexpectedResponseException("Response $key property not found. Resp: " . $this, null, $this);
		}
		return $propData;
	}
}