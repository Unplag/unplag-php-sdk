<?php

namespace Unplag;


use GuzzleHttp\Psr7\Uri;
use Unplag\Exception\UnplagException;

class Request
{

	const CONTENT_MIME = 'application/x-msgpack';
	const METHOD_POST = 'POST';
	const METHOD_GET = 'GET';

	protected $method;
	protected $uri;
	protected $payload;

	public function __construct($method, $uri, $payload = [])
	{
		if(!in_array($method, [static::METHOD_GET, static::METHOD_POST])) {
			throw new \InvalidArgumentException("Invalid method $method");
		}
		$this->method = $method;
		$this->uri = $uri;
		$this->payload = $payload;
	}

	public function payloadSet($key, $value)
	{
		$this->payload[$key] = $value;

		return $this;
	}

	public function payloadGet($key)
	{
		return isset($this->payload[$key]) ? $this->payload[$key] : null;
	}

	public function payloadUnset($key)
	{
		unset($this->payload[$key]);

		return $this;
	}

	protected function packPayload()
	{
		$packer = new \MessagePack\Packer;

		$data = [];
		foreach ($this->payload as $key => &$value)
		{
			if ($value instanceof PayloadFile)
			{
				$data[$key] = &$value->getBinaryData();
			}
			else
			{
				$data[$key] = &$value;
			}
		}


		return $packer->packMap($data);
	}

	public function makeGuzzleRequest()
	{
		$headers = [
			'Accept' => Response::ACCEPT_MIME,
			'Content-Type' => static::CONTENT_MIME
		];

		$uri = new Uri($this->uri);
		if($this->method == self::METHOD_GET) {
			$body = null;
			$new_uri = $uri->withQuery(http_build_query($this->payload));
		}
		else {
			$body = $this->packPayload();
			$new_uri = $uri;
		}

		return new \GuzzleHttp\Psr7\Request($this->method, $new_uri, $headers, $body);
	}

	public function __debugInfo()
	{
		return [
			'method' => $this->method,
		    'uri' => $this->uri,
		    'payload' => $this->payload
		];
	}

	public function __toString()
	{
		ob_start();
		var_dump($this);
		return 'Unplag\Request: ' . ob_get_clean();
	}
}
