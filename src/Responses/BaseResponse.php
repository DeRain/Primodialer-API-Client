<?php

namespace DeRain\Primodialer\Api\Responses;

use GuzzleHttp\Message\Response;

abstract class BaseResponse
{
    const SUCCESS_DELIMITER = 'SUCCESS:';
    const ERROR_DELIMITER = 'ERROR:';
    const NOTICE_DELIMITER = 'NOTICE:';

    /**
     * @var null|Response
     */
    protected $_httpResponse = null;

    /**
     * @var bool
     */
    protected $_hasError = false;

    /**
     * @var bool
     */
    protected $_hasNotice = false;

    /**
     * @var null|string
     */
    protected $_message = null;

    /**
     * BaseResponse constructor.
     *
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->_httpResponse = $response;
        $this->parseError();
        $this->parseNotice();
        if (!$this->hasError() && !$this->hasNotice()) {
            $this->parseSuccess();
        }
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->_message;
    }

    /**
     * @return bool
     */
    public function hasError()
    {
        return $this->_hasError;
    }

    /**
     * @return bool
     */
    public function hasNotice()
    {
        return $this->_hasNotice;
    }

    /**
     * @return string
     */
    protected function getHttpResponse()
    {
        return $this->_httpResponse->getBody()->getContents();
    }

    /**
     * Get status code
     *
     * @return int|string
     */
    protected function getStatusCode()
    {
        return $this->_httpResponse->getStatusCode();
    }

    /**
     *
     */
    protected function parseError()
    {
        $response = $this->getHttpResponse();
        $statusCode = $this->getStatusCode();
        if (mb_strpos($response, self::ERROR_DELIMITER) !== false) {
            $error = explode(self::ERROR_DELIMITER, $response);
            $this->_message = trim($error[1]);
            $this->_hasError = true;
        } elseif ($statusCode != 200) {
            $this->_message = 'Server response with '.$statusCode.' status code.'.PHP_EOL;
            $this->_hasError = true;
        }
    }

    /**
     *
     */
    protected function parseSuccess()
    {
        $response = $this->getHttpResponse();
        if (mb_strpos($response, self::SUCCESS_DELIMITER) !== false) {
            $success = explode(self::SUCCESS_DELIMITER, $response);
            $this->_message = trim($success[1]);
        } else {
            $this->_message = $response;
        }
    }

    /**
     *
     */
    protected function parseNotice()
    {
        $response = $this->getHttpResponse();
        if (mb_strpos($response, self::NOTICE_DELIMITER) !== false) {
            $success = explode(self::NOTICE_DELIMITER, $response);
            $this->_message = trim($success[1]);
            $this->_hasNotice = true;
        }
    }
}
