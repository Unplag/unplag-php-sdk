<?php namespace Unplag\UnplagClient;

use Unplag\Client;
use Unplag\Request;
use Unplag\Response;
use Unplag\PayloadFile;
use Unplag\Exception\UnexpectedResponseException;

/**
 * Class FileTrait
 * @package Unplag\UnplagClient
 * 
 * @method Response execute(Request $request)
 * @method Client getClient()
 */
trait FileTrait
{
    
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
        $params = [
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
            throw new UnexpectedResponseException("File delete repsponse do not contain file ID. " . $resp, null, $resp);
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