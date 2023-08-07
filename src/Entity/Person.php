<?php

namespace belenka\fedex\Entity;

class Person
{

    public $address = null;
    public $personName = '';
    public $phoneNumber;

    /**
     * @param  mixed  $address
     * @return Person
     */
    public function withAddress(Address $address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @param  mixed  $personName
     * @return Person
     */
    public function setPersonName(string $personName)
    {
        $this->personName = $personName;
        return $this;
    }

    /**
     * @param  mixed  $phoneNumber
     * @return Person
     */
    public function setPhoneNumber(int $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * @return array[]
     */
    public function prepare(): array
    {
        $data = [
            'contact' => (object)
            [
                'personName' => $this->personName,
                'phoneNumber' => $this->phoneNumber,
            ],
            'address' => empty($this->address) ? null : $this->address->prepare()
        ];
        return $data;
    }
}
