<?php

namespace belenka\fedex\Services\Ship\Type;

class PaymentType
{

    const SENDER = 'SENDER';
    const RECIPIENT = 'RECIPIENT';
    const THIRD_PARTY = 'THIRD_PARTY';
    const COLLECT = 'COLLECT';
    
    public static function getValidValues()
    {
        return [
            static::SENDER,
            static::RECIPIENT,
            static::THIRD_PARTY,
            static::COLLECT,
        ];
    }
}
