<?php

namespace belenka\fedex\Services\Ship;

use belenka\fedex\Entity\Person;
use belenka\fedex\Entity\AccountNumber;
use belenka\fedex\Exceptions\MissingAccountNumberException;
use belenka\fedex\Exceptions\MissingLineItemException;
use belenka\fedex\Services\AbstractRequest;
use belenka\fedex\Services\Ship\Type\LabelResponseType;
use belenka\fedex\Services\Ship\Type\PaymentType;
use belenka\fedex\Services\Ship\Type\ReturnType;
use belenka\fedex\Services\Ship\Type\LabelStockType;
use belenka\fedex\Services\Ship\Type\ImageType;

/**
 * @see https://developer.fedex.com/api/en-us/catalog/ship/docs.html
 */
class CreateShipmentRequest extends AbstractRequest
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
    
    private $requestedShipment;

    public function __construct()
    {
        $this->requestedShipment = [
            'shipper' => null, 
            'recipients' => null, 
            'shipDatestamp' => null, 
            'serviceType' => null, 
            'packagingType' => null, 
            'pickupType' => null, 
            'blockInsightVisibility' => false,
            'totalDeclaredValue' => null,
            'shippingChargesPayment' => [
                'paymentType' => PaymentType::SENDER,
            ],
            'shipmentSpecialServices' => [
                'specialServiceTypes' => [
                    Type\SpecialServiceType::RETURN_SHIPMENT
                ],
                'returnShipmentDetail' => [
                    'returnType' => ReturnType::PRINT_RETURN_LABEL,
                ],
            ],
            'labelSpecification' => [
                'imageType' => ImageType::PDF,
                'labelStockType' => LabelStockType::PAPER_85X11_TOP_HALF_LABEL,
            ],
            'requestedPackageLineItems' => null, 
        ];
        
        $this->params = [
            'labelResponseOptions' => LabelResponseType::LABEL,
            'requestedShipment' => $this->requestedShipment,
            'accountNumber' => [
                'value' => null, 
            ],
        ];
    }

    public function getRequestParams(): array
    {
        return $this->params;
    }

    public function setRequestParams(array $new_params): CreateShipmentRequest
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
     * @param string $type
     * @return $this
     * @throws MissingAccessTokenException
     */
    public function setLabelResponseOptions($type)
    {
        if(!in_array($type, LabelResponseTypeL::getValidValues())) {
            throw new \Exception('Invalid labelResponseOptions type.');
        }
        
        $this->params['labelResponseOptions'] = $type;
        return $this;
    }
    
    /**
     * @param float $amount
     * @param string $currency_code https://developer.fedex.com/api/en-us/guides/api-reference.html#currencycodes
     * @return $this
     */
    public function setTotalDeclaredValue($amount, $currency_code)
    {
        $this->requestedShipment['totalDeclaredValue'] = [
            'amount' => $amount,
            'currency' => $currency_code
        ];
        return $this;
    }
    
    /**
     * @param  string  $pickup_type
     * @return CreateTagRequest
     */
    public function setPickupType(string $pickup_type): CreateShipmentRequest
    {
        $this->requestedShipment['pickupType'] = $pickup_type;
        return $this;
    }
    
    /**
     * @param  string  $shippingDocumentSpecification
     * @return CreateTagRequest
     */
    public function setShippingDocumentSpecification(string $shippingDocumentSpecification): CreateShipmentRequest
    {
        /*
        "shippingDocumentSpecification": {
            "shippingDocumentTypes": 
            [
                "COMMERCIAL_INVOICE"
            ],
            "commercialInvoiceDetail": 
            {
                "documentFormat": 
                    {
                        "stockType": "PAPER_LETTER",
                        "docType": "PDF"
                    }
                }
            },
        },
        */

	$this->requestedShipment['shippingDocumentSpecification'] = $shippingDocumentSpecification;
        return $this;
    }
    
    /**
     * @param  string  $customsClearanceDetail
     * @return CreateTagRequest
     */
    public function setCustomsClearanceDetail(string $customsClearanceDetail): CreateShipmentRequest
    {
//        "customsClearanceDetail": {
//            "dutiesPayment": 
//            {
//                "paymentType": "SENDER"
//            },
//            "isDocumentOnly": true,
//            "commodities": 
//            [
//                {
//                    "description": "Commodity description",
//                    "countryOfManufacture": "US",
//                    "quantity": 1,
//                    "quantityUnits": "PCS",
//                    "unitPrice":  {},
//                    "customsValue":  {},
//                    "weight":  {}
//                }
//            ]
//        },
        
        $this->requestedShipment['customsClearanceDetail'] = $customsClearanceDetail;
        return $this;
    }
    
    /**
     * @param  array  $shippingChargesPayment
     * @return CreateTagRequest
     */
    public function setShippingChargesPayment(array $shippingChargesPayment): CreateShipmentRequest
    {
        if(isset($shippingChargesPayment['paymentType'])) {
            if(!in_array($shippingChargesPayment['paymentType'], PaymentType::getValidValues())) {
                throw new \Exception('Invalid shippingChargesPayment -> paymentType value.');
            }
        }
        
        $this->requestedShipment['shippingChargesPayment'] = $shippingChargesPayment;
        return $this;
    }
    
    /**
     * @param  array  $shipmentSpecialServices
     * @return CreateTagRequest
     */
    public function setShipmentSpecialServices(array $shipmentSpecialServices): CreateShipmentRequest
    {
        if(isset($shipmentSpecialServices['specialServiceTypes'])) {
            if(!in_array($shipmentSpecialServices['specialServiceTypes'], SpecialServiceType::getValidValues())) {
                throw new \Exception('Invalid shippingChargesPayment -> specialServiceTypes value.');
            }
        }
        
        if(isset($shipmentSpecialServices['returnShipmentDetail']) && isset($shipmentSpecialServices['returnShipmentDetail']['returnType'])) {
            if(!in_array($shipmentSpecialServices['returnShipmentDetail']['returnType'], ReturnType::getValidValues())) {
                throw new \Exception('Invalid shippingChargesPayment -> returnShipmentDetail -> returnType value.');
            }
        }
        
        $this->requestedShipment['shipmentSpecialServices'] = $shipmentSpecialServices;
        return $this;
    }
    
    /**
     * @param  string  $shipAction
     * @return CreateTagRequest
     */
    public function setShipAction(string $shipAction): CreateShipmentRequest
    {
        $this->params['shipAction'] = $shipAction;
        return $this;
    }
    
    /**
     * @param  string  $processingOptionType
     * @return CreateTagRequest
     */
    public function setProcessingOptionType(string $processingOptionType): CreateShipmentRequest
    {
        $this->params['processingOptionType'] = $processingOptionType;
        return $this;
    }
    
    /**
     * @param  string  $mergeLabelDocOption
     * @return CreateTagRequest
     */
    public function setMergeLabelDocOption(string $mergeLabelDocOption): CreateShipmentRequest
    {
        $this->params['mergeLabelDocOption'] = $mergeLabelDocOption;
        return $this;
    }
    
    /**
     * @param  bool  $blockInsightVisibility
     * @return CreateTagRequest
     */
    public function setBlockInsightVisibility(bool $blockInsightVisibility): CreateShipmentRequest
    {
        $this->requestedShipment['blockInsightVisibility'] = $blockInsightVisibility;
        return $this;
    }
    
    /**
     * @param  bool  $oneLabelAtATime
     * @return CreateTagRequest
     */
    public function setOneLabelAtATime(bool $oneLabelAtATime): CreateShipmentRequest
    {
        $this->params['oneLabelAtATime'] = $oneLabelAtATime;
        return $this;
    }
    
    /**
     * @param  string  $recipientLocationNumber
     * @return CreateTagRequest
     */
    public function setRecipientLocationNumber(string $recipientLocationNumber): CreateShipmentRequest
    {
        $this->requestedShipment['recipientLocationNumber'] = $recipientLocationNumber;
        return $this;
    }
    
    /**
     * @param  array  $requestedPackageLineItems
     * @return CreateTagRequest
     */
    public function setRequestedPackageLineItems(array $requestedPackageLineItems): CreateShipmentRequest
    {
        $this->requestedShipment['requestedPackageLineItems'] = $requestedPackageLineItems;
        return $this;
    }
    
    /**
     * @param  string  $totalPackageCount
     * @return CreateTagRequest
     */
    public function setTotalPackageCount(string $totalPackageCount): CreateShipmentRequest
    {
        $this->requestedShipment['totalPackageCount'] = $totalPackageCount;
        return $this;
    }
    
    /**
     * @param  string  $preferredCurrency
     * @return CreateTagRequest
     */
    public function setPreferredCurrency(string $preferredCurrency): CreateShipmentRequest
    {
        $this->requestedShipment['preferredCurrency'] = $preferredCurrency;
        return $this;
    }

    /**
     * @param  string  $packaging_type
     * @return CreateTagRequest
     */
    public function setPackagingType(string $packaging_type): CreateShipmentRequest
    {
        $this->requestedShipment['packagingType'] = $packaging_type;
        return $this;
    }

    /**
     * @param  string  $totalWeight
     * @return CreateTagRequest
     */
    public function setTotalWeight(string $totalWeight): CreateShipmentRequest
    {
        $this->requestedShipment['totalWeight'] = $totalWeight;
        return $this;
    }

    /**
     * @param  string  $ship_datestamp
     * @return CreateTagRequest
     */
    public function setShipDatestamp(string $ship_datestamp): CreateShipmentRequest
    {
        $this->requestedShipment['shipDatestamp'] = $ship_datestamp;
        return $this;
    }

    /**
     * @param  mixed  $service_type
     * @return CreateTagRequest
     */
    public function setServiceType(string $service_type): CreateShipmentRequest
    {
        $this->requestedShipment['serviceType'] = $service_type;
        return $this;
    }

    /**
     * @param  Person  $shipper
     * @return $this
     */
    public function setShipper(Person $shipper): CreateShipmentRequest
    {
        $this->requestedShipment['shipper'] = $shipper;
        return $this;
    }

    /**
     * @param  Person  $origin
     * @return $this
     */
    public function setOrigin(Person $origin): CreateShipmentRequest
    {
        $this->requestedShipment['origin'] = $origin;
        return $this;
    }

    /**
     * @param  Person  $recipients
     * @return $this
     */
    public function setRecipients(Person $recipients): CreateShipmentRequest
    {
        $this->requestedShipment['recipients'] = $recipients;
        return $this;
    }

    /**
     * @param  Person  $soldTo
     * @return $this
     */
    public function setSoldTo(Person $soldTo): CreateShipmentRequest
    {
        $this->requestedShipment['soldTo'] = $soldTo;
        return $this;
    }

    /**
     * @param  int  $account_number
     * @return $this
     */
    public function setAccountNumber(AccountNumber $account_number): CreateShipmentRequest
    {
        $this->params['accountNumber'] = $account_number->prepare();
        return $this;
    }

    
    
    /**
     * @return array[]
     */
    public function prepare(): array
    {
        $this->params['requestedShipment'] = array_merge($this->params['requestedShipment'], $this->requestedShipment);
        
        return [
            'json' => $this->params
        ];
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
        return $this->http_client->post($this->getApiUri($this->setApiEndpoint()), $this->prepare());
    }

}
