<?php

namespace belenka\fedex\Entity;

class Weight
{

    public $unit = '';
    public $value = '';

    /**
     * @param  string  $unit
     * @return Weight
     */
    public function setUnit(string $unit): Weight
    {
        $this->unit = $unit;
        return $this;
    }

    /**
     * @param  int  $value
     * @return Weight
     */
    public function setValue(int $value): Weight
    {
        $this->value = $value;
        return $this;
    }
}
