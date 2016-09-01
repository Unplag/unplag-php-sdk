<?php namespace Unplag;

use Unplag\UnplagClient\CallbackTrait;
use Unplag\UnplagClient\CheckTrait;
use Unplag\UnplagClient\FileTrait;
use Unplag\UnplagClient\IUnplag;
use Unplag\Exception\UnexpectedResponseException;

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



    /**
     * Method fileUpload description.
     * @param PayloadFile $file
     * @param $format
     * @param null $name
     *
     * @return null
     * @throws UnexpectedResponseException
     */
    public function fileUpload(PayloadFile $file, $format, $name = null)
    {
        $params =
            [
                'file' => $file,
                'format' => $format
            ];

        if ($name)
        {
            $params['name'] = $name;
        }

        $req = new Request(Request::METHOD_POST, 'file/upload', $params);
        return $this->execute($req)->getExpectedDataProperty('file');
    }

    /**
     * Method fileDelete description.
     * @param $fileId
     *
     * @return mixed
     * @throws UnexpectedResponseException
     */
    public function fileDelete($fileId)
    {
        $req = new Request(Request::METHOD_POST, 'file/delete', [
            'id' => $fileId
        ]);
        $resp = $this->execute($req);
        $fileData = $resp->getExpectedDataProperty('file');
        if (!isset($fileData['id']))
        {
            throw new UnexpectedResponseException("File delete response do not contain file ID. " . $resp, null, $resp);
        }
        return $fileData['id'];
    }


    /**
     * Method fileGet description.
     * @param $fileId
     *
     * @return null
     * @throws UnexpectedResponseException
     */
    public function fileGet($fileId)
    {
        $req = new Request(Request::METHOD_GET, 'file/get', [
            'id' => $fileId
        ]);
        return $this->execute($req)->getExpectedDataProperty('file');
    }

    


}