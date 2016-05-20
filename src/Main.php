<?php

namespace DeRain\Primodialer\Api;
use DeRain\Primodialer\Api\Exceptions\InvalidArgumentException;
use DeRain\Primodialer\Api\Methods\BaseMethod;
use DeRain\Primodialer\Api\Models\BaseModel;
use DeRain\Primodialer\Api\Responses\BaseResponse;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Respect\Validation\Validator;

class Main
{
    /** @var null|string  */
    private $_apiUrl = null;
    /** @var null|string  */   
    private $_username = null;
    /** @var null|string */
    private $_password = null;
    /** @var string  */
    private $_source = 'DeRain-api-client';

    /**
     * Main constructor.
     * @param array $config
     */
    public function __construct(array $config = null)
    {
        if ($config !== null) {
            foreach ($config as $key => $value) {
                if (property_exists($this, '_' . $key)) {
                    $this->{'_' . $key} = $value;
                }
            }
        }
    }

    /**
     * @param $apiUrl
     */
    public function setApiUrl($apiUrl)
    {
        $this->_apiUrl = $apiUrl;
    }

    /**
     * @param $username
     */
    public function setUsername($username)
    {
        $this->_username = $username;
    }

    /**
     * @param $password
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * @param $source
     */
    public function setSource($source)
    {
        if (Validator::length(1, 20)->validate($source)) {
            $this->_source = $source;
        }
    }

    /**
     * @param BaseMethod $method
     * @param BaseModel $model
     * @return BaseResponse
     * @throws InvalidArgumentException
     */
    public function makeRequest(BaseMethod $method, BaseModel $model)
    {
        try {
            $uri = new Uri($this->_apiUrl);
            $uri = Uri::withQueryValue($uri, 'user', $this->_username);
            $uri = Uri::withQueryValue($uri, 'pass', $this->_password);
            $uri = Uri::withQueryValue($uri, 'source', $this->_source);
            $request = new Request('GET', $uri);
            return $method($request, $model);
        } catch (\InvalidArgumentException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }
}
