<?php

namespace belenka\fedex\Services\Ship\Type;

class ReturnType
{

    const PENDING = 'PENDING';
    const PRINT_RETURN_LABEL = 'PRINT_RETURN_LABEL';
    
    public static function getValidValues()
    {
        return [
            static::PENDING,
            static::PRINT_RETURN_LABEL,
        ];
    }
}
