<?php

namespace DeRain\Primodialer\Api\Methods;

use DeRain\Primodialer\Api\Exceptions\InvalidArgumentException;
use GuzzleHttp\Message\Request;

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
        $query = $request->getQuery();
        $query->add('function', $this->getUriFunction());
        return $next($request);
    }
}
