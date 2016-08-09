<?php

namespace Sunspikes\Amadeus;

/**
 * Class FarePricePNRWithBookingClass
 *
 * @package Sunspikes\Amadeus
 */
class FarePricePnrWithBookingClass extends AbstractAmadeusCommand
{
    private $code;

    /**
     * @param null $code
     */
    public function __construct($code = null)
    {
        $this->code = $code;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        $params['Fare_PricePNRWithBookingClass']['overrideInformation']['attributeDetails'][0]['attributeType'] = 'RLO';
        $params['Fare_PricePNRWithBookingClass']['overrideInformation']['attributeDetails'][1]['attributeType'] = 'RP';
        $params['Fare_PricePNRWithBookingClass']['overrideInformation']['attributeDetails'][2]['attributeType'] = 'RU';
        //$params['Fare_PricePNRWithBookingClass']['overrideInformation']['validatingCarrier']['carrierInformation']['carrierCode'] = $code;

        return $params;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Fare_PricePNRWithBookingClass';
    }
}
