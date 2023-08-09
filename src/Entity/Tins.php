<?php

namespace belenka\fedex\Entity;

class Tins
{
    public $number;
    public $tinType;
    public $usage;
    public $effectiveDate;
    public $expirationDate;

    /**
     * @param $number
     * @return $this
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @param  string  $tinType
     * @return $this
     */
    public function setTinType(string $tinType)
    {
        $this->tinType = $tinType;
        return $this;
    }

    /**
     * @param  string  $usage
     * @return $this
     */
    public function setUsage(string $usage)
    {
        $this->usage = $usage;
        return $this;
    }

    /**
     * @param  int|string  $effectiveDate
     * @return $this
     */
    public function setEffectiveDate(string $effectiveDate)
    {
        $this->effectiveDate = $effectiveDate;
        return $this;
    }

    /**
     * @param  string  $expirationDate
     * @return $this
     */
    public function setExpirationDate(string $expirationDate)
    {
        $this->expirationDate = $expirationDate;
        return $this;
    }

    public function prepare()
    {
        return [
            'number' => $this->number,
            'tinType' => $this->tinType,
            'usage' => $this->usage,
            'effectiveDate' => $this->effectiveDate,
            'expirationDate' => $this->expirationDate,
        ];
    }
}
