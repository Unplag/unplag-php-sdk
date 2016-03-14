<?php

namespace Unplag\Exception;

use Unplag\Request;
use Unplag\Response;

class ResponseException extends \Exception implements UnplagException
{
	const CODE_RESPONSE_PARSE_FAIL = 203;
	const CODE_INVALID_CONTENT_TYPE = 204;

	protected $req;
	protected $resp = null;

	public function __construct($message, $code, \Exception $previous = null, Request $request, Response $response = null)
	{
		$this->req = $request;
		$this->resp = $response;
		parent::__construct($message, $code, $previous);

	}

	public function getRequest() {
		return $this->req;
	}

	public function getResponse() {
		return $this->resp;
	}

	public function hasResponse() {
		return (bool)$this->getResponse();
	}
}