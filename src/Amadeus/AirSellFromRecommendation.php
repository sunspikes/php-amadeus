<?php

namespace Sunspikes\Amadeus;

/**
 * Class AirSellFromRecommendation
 *
 * Set travel segments
 *
 * @package Sunspikes\Amadeus
 */
class AirSellFromRecommendation extends AbstractAmadeusCommand
{
    private $from;
    private $to;
    private $segments;

    /**
     * @param $from
     * @param $to
     * @param $segments
     */
    public function __construct($from, $to, $segments)
    {
        $this->from = $from;
        $this->to = $to;
        $this->segments = $segments;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        $params['Air_SellFromRecommendation']['messageActionDetails']['messageFunctionDetails']['messageFunction']
            = 183;
        $params['Air_SellFromRecommendation']['messageActionDetails']['messageFunctionDetails']['additionalMessageFunction']
            = 'M1';
        $params['Air_SellFromRecommendation']['itineraryDetails']['originDestinationDetails']['origin']
            = $this->from;
        $params['Air_SellFromRecommendation']['itineraryDetails']['originDestinationDetails']['destination']
            = $this->to;
        $params['Air_SellFromRecommendation']['itineraryDetails']['message']['messageFunctionDetails']['messageFunction']
            = 183;

        $i = 0;
        foreach ($this->segments as $segment) {
            $params['Air_SellFromRecommendation']['itineraryDetails']['segmentInformation'][$i]['travelProductInformation']['flightDate']['departureDate']
                = $segment['dep_date'];
            $params['Air_SellFromRecommendation']['itineraryDetails']['segmentInformation'][$i]['travelProductInformation']['boardPointDetails']['trueLocationId']
                = $segment['dep_location'];
            $params['Air_SellFromRecommendation']['itineraryDetails']['segmentInformation'][$i]['travelProductInformation']['offpointDetails']['trueLocationId']
                = $segment['dest_location'];
            $params['Air_SellFromRecommendation']['itineraryDetails']['segmentInformation'][$i]['travelProductInformation']['companyDetails']['marketingCompany']
                = $segment['company'];
            $params['Air_SellFromRecommendation']['itineraryDetails']['segmentInformation'][$i]['travelProductInformation']['flightIdentification']['flightNumber']
                = $segment['flight_no'];
            $params['Air_SellFromRecommendation']['itineraryDetails']['segmentInformation'][$i]['travelProductInformation']['flightIdentification']['bookingClass']
                = $segment['class'];
            $params['Air_SellFromRecommendation']['itineraryDetails']['segmentInformation'][$i]['relatedproductInformation']['quantity']
                = $segment['passengers'];
            $params['Air_SellFromRecommendation']['itineraryDetails']['segmentInformation'][$i]['relatedproductInformation']['statusCode']
                = 'NN';
            $i++;
        }

        return $params;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Air_SellFromRecommendation';
    }
}
