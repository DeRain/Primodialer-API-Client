<?php

namespace DeRain\Primodialer\Api\Methods;

use DeRain\Primodialer\Api\Models\Lead;

class AddLead extends BaseMethod
{
    /**
     * @return string
     */
    protected function getUriFunction()
    {
        return 'add_lead';
    }

    /**
     * @param $model
     * @return bool
     */
    protected function checkModel($model)
    {
        return $model instanceof Lead;
    }
}
