<?php
/**
 * Created by IntelliJ IDEA.
 * User: egormelnikov
 * Date: 12.03.16
 * Time: 18:53
 */

namespace Unplag;


class ApiError
{
	protected $code;
	protected $msg;
	protected $httpStatusCode;

	/**
	 * ApiError constructor.
	 *
	 * @param $code
	 * @param $msg
	 * @param $httpStatusCode
	 */
	public function __construct($code, $msg, $httpStatusCode)
	{
		$this->code = $code;
		$this->msg = $msg;
		$this->httpStatusCode = $httpStatusCode;
	}

	/**
	 * @return mixed
	 */
	public function getCode()
	{
		return $this->code;
	}

	/**
	 * @return mixed
	 */
	public function getMsg()
	{
		return $this->msg;
	}

	/**
	 * @return mixed
	 */
	public function getHttpStatusCode()
	{
		return $this->httpStatusCode;
	}

	public function __toString()
	{
		$pattern = "Unplag API error. Code: %s; Msg: %s; HTTP status code: %d";
		return sprintf($pattern, $this->getCode(), $this->getMsg(), $this->getHttpStatusCode());
	}
}