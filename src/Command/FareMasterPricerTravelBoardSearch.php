<?php
/*
 * Amadeus Flight Booking and Search & Booking API Client
 *
 * (c) Krishnaprasad MG <sunspikes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sunspikes\Amadeus\Command;

/**
 * Class FareMasterPricerTravelBoardSearch
 *
 * Search for lowest fare
 *
 * @package Sunspikes\Amadeus
 */
class FareMasterPricerTravelBoardSearch extends AbstractAmadeusCommand
{
    private $departureDate;
    private $departureLocation;
    private $arrivalLocation;
    private $travellers;
    private $returnDate;

    /**
     * @param $departureDate
     * @param $departureLocation
     * @param $arrivalLocation
     * @param $travellers
     * @param null $returnDate
     */
    public function __construct($departureDate, $departureLocation, $arrivalLocation, $travellers, $returnDate = null)
    {
        $this->departureDate = $departureDate;
        $this->departureLocation = $departureLocation;
        $this->arrivalLocation = $arrivalLocation;
        $this->travellers = $travellers;
        $this->returnDate = $returnDate;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        $j = 0;
        $params['Fare_MasterPricerTravelBoardSearch']['numberOfUnit']['unitNumberDetail'][$j]['numberOfUnits']
            = $this->travellers['A'] + $this->travellers['C'];
        $params['Fare_MasterPricerTravelBoardSearch']['numberOfUnit']['unitNumberDetail'][$j]['typeOfUnit'] = 'PX';
        $params['Fare_MasterPricerTravelBoardSearch']['numberOfUnit']['unitNumberDetail'][$j + 1]['numberOfUnits']
            = 200;
        $params['Fare_MasterPricerTravelBoardSearch']['numberOfUnit']['unitNumberDetail'][$j + 1]['typeOfUnit'] = 'RC';
        $params['Fare_MasterPricerTravelBoardSearch']['paxReference'][$j]['ptc'] = 'ADT';

        for ($i = 1; $i <= $this->travellers['A']; $i++) {
            $params['Fare_MasterPricerTravelBoardSearch']['paxReference'][$j]['traveller'][]['ref'] = $i;
        }

        if ($this->travellers['C'] > 0) {
            $j++;
            $params['Fare_MasterPricerTravelBoardSearch']['paxReference'][$j]['ptc'] = 'CNN';
            for (; $i <= $this->travellers['C'] + $this->travellers['A']; $i++) {
                $params['Fare_MasterPricerTravelBoardSearch']['paxReference'][$j]['traveller'][]['ref'] = $i;
            }
        }

        if ($this->travellers['I'] > 0) {
            $j++;
            $k = 0;
            $params['Fare_MasterPricerTravelBoardSearch']['paxReference'][$j]['ptc'] = 'INF';
            for (; $i <= $this->travellers['I'] + $this->travellers['C'] + $this->travellers['A']; $i++) {
                $params['Fare_MasterPricerTravelBoardSearch']['paxReference'][$j]['traveller'][$k]['ref'] = $i;
                $params['Fare_MasterPricerTravelBoardSearch']['paxReference'][$j]['traveller'][$k]['infantIndicator']
                    = 1;
                $k++;
            }
        }

        $params['Fare_MasterPricerTravelBoardSearch']['fareOptions']['pricingTickInfo']['pricingTicketing']['priceType']
            = 'RP';

        $params['Fare_MasterPricerTravelBoardSearch']['itinerary'][0]['requestedSegmentRef']['segRef'] = 1;
        $params['Fare_MasterPricerTravelBoardSearch']['itinerary'][0]['departureLocalization']['depMultiCity']['locationId']
            = $this->departureLocation;
        $params['Fare_MasterPricerTravelBoardSearch']['itinerary'][0]['arrivalLocalization']['arrivalMultiCity']['locationId']
            = $this->arrivalLocation;
        $params['Fare_MasterPricerTravelBoardSearch']['itinerary'][0]['timeDetails']['firstDateTimeDetail']['date']
            = $this->departureDate;

        if ($this->returnDate) {
            $params['Fare_MasterPricerTravelBoardSearch']['itinerary'][1]['requestedSegmentRef']['segRef'] = 2;
            $params['Fare_MasterPricerTravelBoardSearch']['itinerary'][1]['departureLocalization']['depMultiCity']['locationId']
                = $this->arrivalLocation;
            $params['Fare_MasterPricerTravelBoardSearch']['itinerary'][1]['arrivalLocalization']['arrivalMultiCity']['locationId']
                = $this->departureLocation;
            $params['Fare_MasterPricerTravelBoardSearch']['itinerary'][1]['timeDetails']['firstDateTimeDetail']['date']
                = $this->returnDate;
        }

        return $params;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Fare_MasterPricerTravelBoardSearch';
    }
}
