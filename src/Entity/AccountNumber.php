<?php

namespace belenka\fedex\Entity;

class AccountNumber
{

    public $value = '';

    /**
     * @param  string  $value
     * @return AccountNumber
     */
    public function setValue(int $value): AccountNumber
    {
        $this->value = $value;
        return $this;
    }

    public function prepare()
    {
        return [
            'value' => $this->value,
        ];
    }
}
