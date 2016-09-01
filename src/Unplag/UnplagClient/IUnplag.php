<?php namespace Unplag\UnplagClient;

use Unplag\Request;
use Unplag\Response;

/**
 * Interface IUnplag
 * @package Unplag\UnplagClient
 */
interface IUnplag
{
    /**
     * Method getClient description.
     *
     * @return Client
     */
    public function getClient();

    /**
     * Method execute description.
     * @param Request $request
     *
     * @return Response
     */
    public function execute(Request $request);
}