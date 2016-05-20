<?php

namespace DeRain\Primodialer\Api\Responses;

use GuzzleHttp\Psr7\Response;

abstract class BaseResponse
{
    /**
     * @var null|Response
     */
    private $_httpResponse = null;

    /**
     * BaseResponse constructor.
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->_httpResponse = $response;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->_httpResponse->getBody()->getContents();
    }
}
