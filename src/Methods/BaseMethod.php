<?php

namespace DeRain\Primodialer\Api\Methods;

use DeRain\Primodialer\Api\Exceptions\InvalidArgumentException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;

abstract class BaseMethod
{
    /**
     * @return string
     */
    protected abstract function getUriFunction();

    /**
     * @param $model
     * @return boolean
     */
    protected abstract function checkModel($model);

    /**
     * @param Request $request
     * @param callable|null $next
     * @return mixed
     *
     * @throws InvalidArgumentException
     */
    public function __invoke(Request $request, callable $next = null)
    {
        if (!$this->checkModel($next)) {
            throw new InvalidArgumentException('Model ' . get_class($next) .' is not right for this method');
        }
        $uri = new Uri($request->getUri());
        $uri = Uri::withQueryValue($uri, 'function', $this->getUriFunction());
        $request = $request->withUri($uri);
        return $next($request);
    }
}
