<?php namespace Unplag\Helper;

/**
 * Class CallbackResolver
 */
class CallbackResolver
{
    /**
     * @var string
     */
    protected $content;

    /**
     * CallbackResolver constructor.
     */
    public function __construct()
    {

        foreach (getallheaders() as $name => $value)
        {
            echo "$name: $value\n";
        }

        $this->content = file_get_contents("php://input");
        $this->setParams($this->content);
    }

    /**
     * Method setParams description.
     * @param $content
     */
    protected function setParams($content)
    {

    }

}