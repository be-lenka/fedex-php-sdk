<?php

namespace belenka\fedex\Services\Ship\Type;

class SpecialServiceType
{

    const HOLD_AT_LOCATION = 'HOLD_AT_LOCATION';
    const RETURN_SHIPMENT = 'RETURN_SHIPMENT';
    const BROKER_SELECT_OPTION = 'BROKER_SELECT_OPTION';
    const CALL_BEFORE_DELIVERY = 'CALL_BEFORE_DELIVERY';
    const CUSTOM_DELIVERY_WINDOW = 'CUSTOM_DELIVERY_WINDOW';
    const COD = 'COD';
    
    public static function getValidValues()
    {
        return [
            static::HOLD_AT_LOCATION,
            static::RETURN_SHIPMENT,
            static::BROKER_SELECT_OPTION,
            static::CALL_BEFORE_DELIVERY,
            static::CUSTOM_DELIVERY_WINDOW,
            static::COD,
        ];
    }
}
