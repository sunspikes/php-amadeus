<?php

namespace Sunspikes\Amadeus;

/**
 * Class AirMultiAvailability
 *
 * Check airline availability by Flight
 *
 * @package Sunspikes\Amadeus
 */
class AirMultiAvailability extends AbstractAmadeusCommand
{
    private $deprtDate;
    private $deprtLoc;
    private $arriveLoc;
    private $service;
    private $airCode;
    private $airNum;

    public function __construct($deprtDate, $deprtLoc, $arriveLoc, $service, $airCode, $airNum)
    {
        $this->deprtDate = $deprtDate;
        $this->deprtLoc = $deprtLoc;
        $this->arriveLoc = $arriveLoc;
        $this->service = $service;
        $this->airCode = $airCode;
        $this->airNum = $airNum;
    }

    public function getParameters()
    {
        $params['Air_MultiAvailability']['messageActionDetails']['functionDetails']['actionCode'] = 44;
        $params['Air_MultiAvailability']['requestSection']['availabilityProductInfo']['availabilityDetails']['departureDate'] = $this->deprtDate;
        $params['Air_MultiAvailability']['requestSection']['availabilityProductInfo']['departureLocationInfo']['cityAirport'] = $this->deprtLoc;
        $params['Air_MultiAvailability']['requestSection']['availabilityProductInfo']['arrivalLocationInfo']['cityAirport'] = $this->arriveLoc;
        $params['Air_MultiAvailability']['requestSection']['optionClass']['productClassDetails']['serviceClass'] = $this->service;
        $params['Air_MultiAvailability']['requestSection']['airlineOrFlightOption']['flightIdentification']['airlineCode'] = $this->airCode;
        $params['Air_MultiAvailability']['requestSection']['airlineOrFlightOption']['flightIdentification']['number'] = $this->airNum;
        $params['Air_MultiAvailability']['requestSection']['availabilityOptions']['productTypeDetails']['typeOfRequest'] = 'TN';

        return $params;
    }

    public function getName()
    {
        return 'Air_MultiAvailability';
    }
}