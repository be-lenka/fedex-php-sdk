<?php

namespace belenka\fedex\Services\AddressValidation;

use belenka\fedex\Entity\Address;
use belenka\fedex\Services\AbstractRequest;

class AddressValidation extends AbstractRequest
{
    protected $address;

    /**
     * @return string
     */
    public function setApiEndpoint(): string
    {
        return '/address/v1/addresses/resolve';
    }

    /**
     * @param  Address|null  $address
     * @return AddressValidation
     */
    public function setAddress(Address $address): AddressValidation
    {
        $this->address = $address;
        return $this;
    }

    public function prepare(): array
    {
        return [
            'json' => [
                'addressesToValidate' => [
                    [
                        'address' => $this->address->prepare(),
                    ],
                ],
            ],
        ];
    }

    public function request()
    {
        parent::request();
        $query = $this->http_client->post($this->getApiUri($this->api_endpoint), $this->prepare());
        return ($this->raw === true) ? $query : json_decode($query->getBody()->getContents());
    }
}
