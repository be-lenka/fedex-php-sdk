<?php

namespace belenka\fedex\Services\Ship;

use belenka\fedex\Entity\Item;
use belenka\fedex\Entity\Person;
use belenka\fedex\Exceptions\MissingAccountNumberException;
use belenka\fedex\Exceptions\MissingLineItemException;
use belenka\fedex\Services\AbstractRequest;
use belenka\fedex\Services\Ship\Type\ServiceType;

class CreateTagRequest extends AbstractRequest
{
    protected $account_number;
    protected $shipper;
    protected $recipients;
    protected $line_items;
    protected $service_type;
    protected $packaging_type;
    protected $pickup_type;
    protected $ship_datestamp = '';
    protected $params;

    public function __construct()
    {
        $this->params = [
            'json' => [
                'labelResponseOptions' => 'LABEL',
                'requestedShipment' => [
                    'shipper' => null, 
                    'recipients' => null, 
                    'shipDatestamp' => null, 
                    'serviceType' => null, 
                    'packagingType' => null, 
                    'pickupType' => null, 
                    'blockInsightVisibility' => false,
                    'shippingChargesPayment' => [
                        'paymentType' => 'SENDER',
                    ],
                    'shipmentSpecialServices' => [
                        'specialServiceTypes' => [
                            'RETURN_SHIPMENT',
                        ],
                        'returnShipmentDetail' => [
                            'returnType' => 'PRINT_RETURN_LABEL',
                        ],
                    ],
                    'labelSpecification' => [
                        'imageType' => 'PDF',
                        'labelStockType' => 'PAPER_85X11_TOP_HALF_LABEL',
                    ],
                    'requestedPackageLineItems' => null, 
                ],
                'accountNumber' => [
                    'value' => null, 
                ],
            ],
        ];
    }

    public function getRequestParams(): array
    {
        return $this->params;
    }


    public function setRequestParams(array $new_params): CreateTagRequest
    {
        $this->params = $new_params;
	    return $this;
    }

    /**
     * @inheritDoc
     */
    public function setApiEndpoint(): string
    {
        return '/ship/v1/shipments';
    }

    /**
     * @return string
     */
    public function getPickupType(): string
    {
        return $this->pickup_type;
    }

    /**
     * @param  string  $pickup_type
     * @return CreateTagRequest
     */
    public function setPickupType(string $pickup_type): CreateTagRequest
    {
        $this->pickup_type = $pickup_type;
        return $this;
    }

    /**
     * @return string
     */
    public function getPackagingType(): string
    {
        return $this->packaging_type;
    }

    /**
     * @param  string  $packaging_type
     * @return CreateTagRequest
     */
    public function setPackagingType(string $packaging_type): CreateTagRequest
    {
        $this->packaging_type = $packaging_type;
        return $this;
    }

    /**
     * @return Item
     */
    public function getLineItems(): Item
    {
        return $this->line_items;
    }

    /**
     * @param  Item  $line_items
     * @return $this
     */
    public function setLineItems(Item $line_items): CreateTagRequest
    {
        $this->line_items = $line_items;
        return $this;
    }

    /**
     * @param  string  $ship_datestamp
     * @return CreateTagRequest
     */
    public function setShipDatestamp(string $ship_datestamp): CreateTagRequest
    {
        $this->ship_datestamp = $ship_datestamp;
        return $this;
    }

    /**
     * @param  mixed  $service_type
     * @return CreateTagRequest
     */
    public function setServiceType(string $service_type): CreateTagRequest
    {
        $this->service_type = $service_type;
        return $this;
    }

    /**
     * @return string
     */
    public function getServiceType(): string
    {
        return $this->service_type;
    }

    /**
     * @return array
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }

    /**
     * @return Person
     */
    public function getShipper(): Person
    {
        return $this->shipper;
    }

    /**
     * @param  Person  $shipper
     * @return $this
     */
    public function setShipper(Person $shipper): CreateTagRequest
    {
        $this->shipper = $shipper;
        return $this;
    }

    /**
     * @param  Person  ...$recipients
     * @return $this
     */
    public function setRecipients(Person ...$recipients): CreateTagRequest
    {
        $this->recipients = $recipients;
        return $this;
    }

    /**
     * @param  int  $account_number
     * @return $this
     */
    public function setAccountNumber(int $account_number): CreateTagRequest
    {
        $this->account_number = $account_number;
        return $this;
    }

    /**
     * @return array[]
     */
    public function prepare(): array
    {
    }

    /**
     * @return mixed|\Psr\Http\Message\ResponseInterface|void
     * @throws MissingAccountNumberException
     * @throws MissingLineItemException
     * @throws \belenka\fedex\Exceptions\MissingAccessTokenException
     */
    public function request()
    {
        parent::request();
        return $this->http_client->post($this->getApiUri($this->setApiEndpoint()), $this->params);
    }

}
