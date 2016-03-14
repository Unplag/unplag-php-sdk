<?php
/**
 * Created by IntelliJ IDEA.
 * User: egormelnikov
 * Date: 12.03.16
 * Time: 14:30
 */

namespace Unplag;


use Unplag\Exception\PayloadException;

class PayloadFile
{
	const SOURCE_TYPE_BIN = 1;
	const SOURCE_TYPE_PATH = 2;
	const SOURCE_TYPE_RESOURCE = 3;

	protected $source;
	protected $source_type;

	protected function __construct(&$source, $source_type)
	{
		$this->source = &$source;
		$this->source_type = $source_type;
	}

	/**
	 * @param string $binary_data
	 *
	 * @return static
	 */
	static function bin(&$binary_data) {
		return new static($binary_data, static::SOURCE_TYPE_BIN);
	}

	/**
	 * @param string $path
	 *
	 * @return static
	 * @throws PayloadException
	 */
	static function path($path) {
		if(!is_readable($path)) {
			throw new PayloadException("Path $path is not readable", PayloadException::CODE_PATH_NOT_READABLE);
		}
		return new static($path, static::SOURCE_TYPE_PATH);
	}

	/**
	 * @param resource $resource
	 *
	 * @return static
	 * @throws PayloadException INVALID_RESOURCE
	 */
	static function resource($resource) {
		if(!is_resource($resource)) {
			throw new PayloadException("Not valid resource $resource", PayloadException::CODE_INVALID_RESOURCE);
		}
		return new static($resource, static::SOURCE_TYPE_RESOURCE);
	}

	/**
	 * @return mixed
	 */
	public function &getSource()
	{
		return $this->source;
	}

	/**
	 * @return int
	 */
	public function getSourceType()
	{
		return $this->source_type;
	}

	public function &getBinaryData() {
		switch($this->getSourceType()) {
			case static::SOURCE_TYPE_BIN:
				return $this->getSource();
			case static::SOURCE_TYPE_PATH:
				$data = file_get_contents($this->getSource());
				if($data === false) {
					throw new PayloadException("Failed to read file at path " . $this->getSource(), PayloadException::CODE_FAILED_TO_READ_FILE);
				}
				return $data;
			case static::SOURCE_TYPE_RESOURCE:
				$data = stream_get_contents($this->getSource());
				if($data === false) {
					throw new PayloadException("Failed to read resource ID: " . $this->getSource(), PayloadException::CODE_FAILED_TO_READ_RESOURCE);
				}
				return $data;
		}
	}

	public function __toString()
	{
		return $this->getBinaryData();
	}
}