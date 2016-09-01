<?php namespace Unplag;

use Unplag\UnplagClient\CallbackTrait;
use Unplag\UnplagClient\CheckTrait;
use Unplag\UnplagClient\FileTrait;
use Unplag\UnplagClient\IUnplag;

/**
 * Class Unplag
 * @package Unplag
 */
class Unplag implements IUnplag
{
    
    use FileTrait;
    use CheckTrait;
    use CallbackTrait;

    
    /**
     * @var Client
     */
    protected $client;

    /**
     * Unplag constructor.
     *
     * @param string $key Valid API key 16-32 chars
     * @param string $secret Valid API secret 32-64 chars
     */
    public function __construct($key, $secret)
    {
        $this->client = new Client($key, $secret);
    }

    /**
     * Method getClient description.
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }


    /**
     * Executes Request.
     * Alias for ->getClient()->execute($request)
     * @param Request $request
     *
     * @return Response
     * @throws Exception\ApiException
     * @throws Exception\RequestException
     * @throws Exception\ResponseException
     */
    public function execute(Request $request)
    {
        return $this->getClient()->execute($request);
    }

    


}