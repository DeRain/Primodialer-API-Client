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
     * @param string $value
     */
    public function setPhoneNumber($value)
    {
        $validator = Validator::numeric()->length(6, 16);
        if ($validator->validate($value)) {
            $this->setProperty('phone_number', $value);
        }
    }

    /**
     * @param string $value
     */
    public function setPhoneCode($value)
    {
        $validator = Validator::numeric()->length(1, 4);
        if ($validator->validate($value)) {
            $this->setProperty('phone_code', $value);
        } else {
            $this->setProperty('phone_code', self::DEFAULT_PHONE_CODE);
        }
    }

    /**
     * @param string $value
     */
    public function setListId($value)
    {
        $validator = Validator::numeric()->length(3, 12);
        if ($validator->validate($value)) {
            $this->setProperty('list_id', $value);
        } else {
            $this->setProperty('list_id', self::DEFAULT_LIST_ID);
        }
    }

    /**
     * @param string $value
     */
    public function setFirstName($value)
    {
        if (Validator::length(1, 30)->validate($value)) {
            $this->setProperty('first_name', $value);
        }
    }

    /**
     * @param string $value
     */
    public function setLastName($value)
    {
        if (Validator::length(1, 30)->validate($value)) {
            $this->setProperty('last_name', $value);
        }
    }

    /**
     * @param string $value
     */
    public function setAddress1($value)
    {
        if (Validator::length(1, 100)->validate($value)) {
            $this->setProperty('address1', $value);
        }
    }

    /**
     * @param string $value
     */
    public function setAddress2($value)
    {
        if (Validator::length(1, 100)->validate($value)) {
            $this->setProperty('address2', $value);
        }
    }

    /**
     * @param string $value
     */
    public function setAddress3($value)
    {
        if (Validator::length(1, 100)->validate($value)) {
            $this->setProperty('address3', $value);
        }
    }

    /**
     * @param string $value
     */
    public function setCity($value)
    {
        if (Validator::length(1, 50)->validate($value)) {
            $this->setProperty('city', $value);
        }
    }

    /**
     * @param string $value
     */
    public function setState($value)
    {
        if (Validator::length(1, 2)->validate($value)) {
            $this->setProperty('state', $value);
        }
    }

    /**
     * @param string $value
     */
    public function setPostalCode($value)
    {
        if (Validator::length(1, 10)->validate($value)) {
            $this->setProperty('postal_code', $value);
        }
    }

    /**
     * @param string $value
     */
    public function setCountryCode($value)
    {
        if (Validator::length(1, 3)->validate($value)) {
            $this->setProperty('country_code', $value);
        }
    }

    /**
     * @param string $value
     */
    public function setEmail($value)
    {
        if (Validator::email()->validate($value)) {
            $this->setProperty('email', $value);
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
     * @param string $value
     */
    public function setDuplicateCheck($value)
    {
        $validator = Validator::in([
            'DUPLIST',
            'DUPCAMP',
            'DUPSYS',
            'DUPTITLEALTPHONELIST',
            'DUPTITLEALTPHONECAMP',
            'DUPTITLEALTPHONESYS',
            'DUPNAMEPHONELIST',
            'DUPNAMEPHONECAMP',
            'DUPNAMEPHONESYS'
        ]);
        if ($validator->validate($value)) {
            $this->setProperty('duplicate_check', $value);
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
