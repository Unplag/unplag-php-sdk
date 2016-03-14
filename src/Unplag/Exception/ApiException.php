<?php
/**
 * Created by IntelliJ IDEA.
 * User: egormelnikov
 * Date: 12.03.16
 * Time: 17:40
 */

namespace Unplag\Exception;


use Unplag\ApiError;
use Unplag\Request;
use Unplag\Response;

class ApiException extends \Exception implements UnplagException
{
	const CODE_API_ERRORS = 501;
	const CODE_API_UNKNOWN_ERROR = 502;

	/**
	 * @var ApiError[]
	 */
	protected $errors = [];

	/**
	 * @var Response
	 */
	protected $response;

	/**
	 * @var Request
	 */
	protected $request;

	public function __construct(Request $request, Response $response, \Exception $previous = null)
	{
		if($response->getDataProperty('errors')) {
			foreach($response->getDataProperty('errors') as $err) {
				$this->errors[] = new ApiError($err['error_code'], $err['message'], $response->getStatusCode());
			}
		}

		if($this->errors) {
			$message = "Unplag API exception with " . count($this->errors) . " error(s): " . $this->_build_errors_msg();
			$code = static::CODE_API_ERRORS;
		}
		else {
			$message = "Unplag API exception with unknown errors.";
			$code = static::CODE_API_UNKNOWN_ERROR;
		}

		$message .= " HTTP status code " . $response->getStatusCode();

		$this->request = $request;
		$this->response = $response;

		parent::__construct($message, $code, $previous);
	}

	protected function _build_errors_msg() {
		$msgs = [];
		foreach($this->getErrors() as $error) {
			$msgs[] = sprintf("%s (%s)", $error->getMsg(), $error->getCode());
		}

		return implode(" | ", $msgs);
	}

	/**
	 * @return ApiError[]
	 */
	public function getErrors()
	{
		return $this->errors;
	}

	/**
	 * @return Response
	 */
	public function getResponse()
	{
		return $this->response;
	}

	/**
	 * @return Request
	 */
	public function getRequest()
	{
		return $this->request;
	}
}