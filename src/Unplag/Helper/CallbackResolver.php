<?php namespace Unplag\Helper;
use Unplag\Exception\CallbackException;
use Unplag\Response;

/**
 * Class CallbackResolver
 * @package Unplag\Helper
 */
class CallbackResolver
{
    /**
     * @var array
     */
    protected $params = [];

    /**
     * CallbackResolver constructor.
     */
    public function __construct()
    {
        $contentType = $_SERVER['CONTENT_TYPE'];
        if( strpos(Response::ACCEPT_MIME, $contentType) === false )
        {
            throw new CallbackException('Invalid MIME type');
        }

        $content = file_get_contents("php://input");
        if( empty($content) )
        {
            throw new CallbackException('Callback content body is empty');
        }

        $this->setParams($content);

    }

    /**
     * Method setParams description.
     * @param $content
     *
     * @return $this
     */
    protected function setParams($content)
    {
        $unpacker = new \MessagePack\Unpacker();
        $this->params = $unpacker->unpack($content);
        return $this;
    }

    /**
     * Method getParam description.
     * @param null $index
     *
     * @return array|mixed|null
     */
    public function getParam($index = null)
    {
        if( empty($index) )
        {
            return $this->params;
        }
        
        return isset($this->params[$index]) ? $this->params[$index] : null;
    }


}