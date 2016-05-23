<?php

namespace DeRain\Primodialer\Api\Models;

use DeRain\Primodialer\Api\Exceptions\RemoteCallException;
use DeRain\Primodialer\Api\Responses\BaseResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Query;

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
     *
     * @throws RemoteCallException
     */
    public function __invoke(Request $request)
    {
        try {
            $query = $request->getQuery();
            $this->addParamsToUri($query);
            $client = new Client();
            return $this->getApiResponse($client->send($request));
        } catch (\Exception $e) {
            throw new RemoteCallException($e->getMessage());
        }
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
     * @param Query $query
     */
    private function addParamsToUri(Query $query)
    {
        foreach ($this->_properties as $key => $value)
        {
            $query->set($key, $value);
        }
    }
}
