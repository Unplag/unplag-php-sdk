<?php
/**
 * Created by IntelliJ IDEA.
 * User: egormelnikov
 * Date: 14.03.16
 * Time: 10:15
 */

namespace Unplag\Exception;

use Unplag\Response;

class UnexpectedResponseException extends \Exception implements UnplagException
{
	const CODE_UNEXPECTED_RESPONSE = 601;
	protected $response;

	public function __construct($message, \Exception $previous = null, Response $response)
	{
		parent::__construct($message, static::CODE_UNEXPECTED_RESPONSE, $previous);
		$this->response = $response;
	}

	/**
	 * @return Response
	 */
	public function getResponse()
	{
		return $this->response;
	}


}