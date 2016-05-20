<?php

namespace DeRain\Primodialer\Api\Models;

use DeRain\Primodialer\Api\Responses\BaseResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Uri;

abstract class BaseModel
{
    /**
     * @var array
     */
    protected $_properties = [];

    /**
     * @param Response $response
     * @return BaseResponse
     */
    abstract protected function getApiResponse(Response $response);

    /**
     * @param Request $request
     * @return BaseResponse
     */
    public function __invoke(Request $request)
    {
        $uri = new Uri($request->getUri());
        $uri = $this->addParamsToUri($uri);
        $request = $request->withUri($uri);
        $client = new Client();
        return $this->getApiResponse($client->send($request));
    }

    /**
     * @param $key
     * @param $value
     */
    protected function setProperty($key, $value)
    {
        $this->_properties[$key] = $value;   
    }

    /**
     * @param $key
     * @return mixed|null
     */
    protected function getProperty($key)
    {
        return array_key_exists($key, $this->_properties) ? $this->_properties[$key] : null;
    }

    /**
     * @param Uri|\Psr\Http\Message\UriInterface $uri
     * @return Uri|\Psr\Http\Message\UriInterface
     */
    private function addParamsToUri(Uri $uri)
    {
        foreach ($this->_properties as $key => $value)
        {
            $uri = Uri::withQueryValue($uri, $key, $value);
        }

        return $uri;
    }
}
