<?php

namespace belenka\fedex\Entity;

class Person
{

    public $address = null;
    public $tins = null;
    public $personName = '';
    public $phoneNumber;
    public $companyName;
    public $emailAddress;
    public $phoneExtension;
    public $accountNumber;
    public $faxNumber;
    public $deliveryInstructions;
    
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
     * @param  Tins[] $tins
     * @return Person
     */
    public function withTins(array $tins)
    {
        $this->tins[] = $tins;
        return $this;
    }

    /**
     * @param  AccountNumber  $accountNumber
     * @return Person
     */
    public function setAccountNumber(AccountNumber $accountNumber)
    {
        $this->accountNumber = $accountNumber;
        return $this;
    }

    /**
     * @param  mixed  $deliveryInstructions
     * @return Person
     */
    public function setDeliveryInstructions(string $deliveryInstructions)
    {
        $this->deliveryInstructions = $deliveryInstructions;
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
     * @param  mixed  $phoneExtension
     * @return Person
     */
    public function setPhoneExtension(string $phoneExtension)
    {
        $this->phoneExtension = $phoneExtension;
        return $this;
    }

    /**
     * @param  mixed  $companyName
     * @return Person
     */
    public function setCompanyName(string $companyName)
    {
        $this->companyName = $companyName;
        return $this;
    }

    /**
     * @param  mixed  $emailAddress
     * @return Person
     */
    public function setEmailAddress(string $emailAddress)
    {
        $this->emailAddress = $emailAddress;
        return $this;
    }

    /**
     * @param  mixed  $faxNumber
     * @return Person
     */
    public function setFaxNumber(string $faxNumber)
    {
        $this->faxNumber = $faxNumber;
        return $this;
    }
    
    /**
     * @return array[]
     */
    public function prepare(): array
    {
        $contact = [
            'personName' => $this->personName,
            'phoneNumber' => $this->phoneNumber,
        ];
        
        if($this->phoneExtension) {
            $contact['phoneExtension'] = $this->phoneExtension;
        }
        
        if($this->companyName) {
            $contact['companyName'] = $this->companyName;
        }
        
        if($this->emailAddress) {
            $contact['emailAddress'] = $this->emailAddress;
        }
        
        if($this->faxNumber) {
            $contact['faxNumber'] = $this->faxNumber;
        }
        
        $data = [
            'contact' => (object)$contact,
            'address' => empty($this->address) ? null : $this->address->prepare()
        ];
        
        if($this->tins) {
            foreach($this->tins as $tins) {
                $data['tins'][] = $tins->prepare();
            }
        }
        
        if($this->accountNumber) {
            $data['accountNumber'] = $this->accountNumber->prepare();
        }
        
        if($this->deliveryInstructions) {
            $data['deliveryInstructions'] = $this->deliveryInstructions;
        }
        
        return $data;
    }
}
