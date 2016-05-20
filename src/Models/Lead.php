<?php

namespace DeRain\Primodialer\Api\Models;

use DeRain\Primodialer\Api\Responses\LeadResponse;
use GuzzleHttp\Psr7\Response;
use Respect\Validation\Validator;

class Lead extends BaseModel
{
    const DEFAULT_PHONE_CODE = 1;
    const DEFAULT_LIST_ID = 999;

    /**
     * @param string $number
     */
    public function setPhoneNumber($number)
    {
        $validator = Validator::numeric()->length(6, 16);
        if ($validator->validate($number)) {
            $this->setProperty('phone_number', $number);
        }
    }

    /**
     * @param string $code
     */
    public function setPhoneCode($code)
    {
        $validator = Validator::numeric()->length(1, 4);
        if ($validator->validate($code)) {
            $this->setProperty('phone_code', $code);
        } else {
            $this->setProperty('phone_code', self::DEFAULT_PHONE_CODE);
        }
    }

    /**
     * @param string $listId
     */
    public function setListId($listId)
    {
        $validator = Validator::numeric()->length(3, 12);
        if ($validator->validate($listId)) {
            $this->setProperty('list_id', $listId);
        } else {
            $this->setProperty('list_id', self::DEFAULT_LIST_ID);
        }
    }

    /**
     * @param string $value
     */
    public function setDncCheck($value)
    {
        $validator = Validator::in(['AREACODE', 'Y', 'N']);
        if ($validator->validate($value)) {
            $this->setProperty('dnc_check', $value);
        } else {   
            $this->setProperty('dnc_check', 'N');
        }
    }

    /**
     * @param string $id
     */
    public function setCampaignId($id)
    {
        $validator = Validator::numeric()->length(2, 8);
        if ($validator->validate($id)) {
            $this->setProperty('campaign_id', $id);
        }
    }

    /**
     * @param string $value
     */
    public function setAddToHopper($value)
    {
        $validator = Validator::in(['N', 'Y']);
        if ($validator->validate($value)) {
            $this->setProperty('add_to_hopper', $value);
        }
    }

    /**
     * @param Response $response
     * @return LeadResponse
     */
    protected function getApiResponse(Response $response)
    {
        return new LeadResponse($response);
    }
}
