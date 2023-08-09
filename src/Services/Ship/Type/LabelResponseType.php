<?php

namespace belenka\fedex\Services\Ship\Type;

class LabelResponseType
{

    const URL_ONLY = 'URL_ONLY';
    const LABEL = 'LABEL';
    
    public static function getValidValues()
    {
        return [
            static::LABEL,
            static::URL_ONLY
        ];
    }
}
