<?php
/*
 * Amadeus Flight Booking and Search & Booking API Client
 *
 * (c) Krishnaprasad MG <sunspikes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Amadeus;

/**
 * @see https://extranets.us.amadeus.com
 */
class Client
{
    /**
     * The main Amadeus WS namespace
     *
     * @var string
     */
    const AMD_HEAD_NAMESPACE =  'http://webservices.amadeus.com/definitions';

    /**
     * Response data
     */
    private $_data = null;

    /**
     * Response headers
     */
    private $_headers = null;

    /**
     * Hold the client object
     */
    private $_client = null;

    /**
     * Indicates debug mode on/off
     */
    private $_debug = false;

    /**
     * @param $wsdl  string   Path to the WSDL file
     * @param $debug boolean  Enable/disable debug mode
     */
    public function __construct($wsdl, $debug = false)
    {
        $this->_debug = $debug;
        $this->_client = new \SoapClient($wsdl, array('trace'=> $debug));
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->_headers;
    }

    /**
     * Security_Authenticate
     * Autheticates with Amadeus
     *
     * @param string  $source   sourceOffice string
     * @param string  $origin   originator string
     * @param string  $password password binaryData
     * @param integer $passlen  length of binaryData
     * @param string  $org      organizationId string
     */
    public function securityAuthenticate($source, $origin, $password, $passlen, $org)
    {
        $params = array();
        $params['Security_Authenticate']['userIdentifier']['originIdentification']['sourceOffice'] = $source;
        $params['Security_Authenticate']['userIdentifier']['originatorTypeCode'] = 'U';
        $params['Security_Authenticate']['userIdentifier']['originator'] = $origin;
        $params['Security_Authenticate']['dutyCode']['dutyCodeDetails']['referenceQualifier'] = 'DUT';
        $params['Security_Authenticate']['dutyCode']['dutyCodeDetails']['referenceIdentifier'] = 'SU';
        $params['Security_Authenticate']['systemDetails']['organizationDetails']['organizationId'] = $org;
        $params['Security_Authenticate']['passwordInfo']['dataLength'] = $passlen;
        $params['Security_Authenticate']['passwordInfo']['dataType'] = 'E';
        $params['Security_Authenticate']['passwordInfo']['binaryData'] = $password;

        $this->_data = $this->_client->__soapCall('Security_Authenticate', $params, null,
            new \SoapHeader(Client::AMD_HEAD_NAMESPACE, 'SessionId', null), $this->_headers);

        $this->debugDump($params, $this->_data);
    }

    /**
     * Security_SignOut
     * Signs out from Amadeus
     */
    public function securitySignout()
    {
        $params = array();
        $params['Security_SignOut']['SessionId'] = $this->_headers['SessionId'];

        $this->_data = $this->_client->__soapCall('Security_SignOut', $params, null,
            new \SoapHeader(Client::AMD_HEAD_NAMESPACE, 'SessionId', $this->_headers['SessionId']), $this->_headers);

        $this->debugDump($params, $this->_data);
    }

    /**
     * Command_Cryptic
     *
     * @param string $string The string to be sent
     */
    public function commandCryptic($string)
    {
        $params = array();
        $params['Command_Cryptic']['longTextString']['textStringDetails'] = $string;
        $params['Command_Cryptic']['messageAction']['messageFunctionDetails']['messageFunction'] = 'M';

        $this->_data = $this->_client->__soapCall('Command_Cryptic', $params, null,
            new \SoapHeader(Client::AMD_HEAD_NAMESPACE, 'SessionId', $this->_headers['SessionId']), $this->_headers);

        $this->debugDump($params, $this->_data);
    }

    /**
     * Air_MultiAvailability
     * Check airline availability by Flight
     *
     * @param string $deprt_date Departure date
     * @param string $deprt_loc  Departure location
     * @param string $arrive_loc Arrival location
     * @param string $service    Class of service
     * @param string $air_code   Airline code
     * @param string $air_num    Airline number
     */
    public function airFlightAvailability($deprt_date, $deprt_loc, $arrive_loc, $service, $air_code, $air_num)
    {
        $params = array();
        $params['Air_MultiAvailability']['messageActionDetails']['functionDetails']['actionCode'] = 44;
        $params['Air_MultiAvailability']['requestSection']['availabilityProductInfo']['availabilityDetails']['departureDate'] = $deprt_date;
        $params['Air_MultiAvailability']['requestSection']['availabilityProductInfo']['departureLocationInfo']['cityAirport'] = $deprt_loc;
        $params['Air_MultiAvailability']['requestSection']['availabilityProductInfo']['arrivalLocationInfo']['cityAirport'] = $arrive_loc;
        $params['Air_MultiAvailability']['requestSection']['optionClass']['productClassDetails']['serviceClass'] = $service;
        $params['Air_MultiAvailability']['requestSection']['airlineOrFlightOption']['flightIdentification']['airlineCode'] = $air_code;
        $params['Air_MultiAvailability']['requestSection']['airlineOrFlightOption']['flightIdentification']['number'] = $air_num;
        $params['Air_MultiAvailability']['requestSection']['availabilityOptions']['productTypeDetails']['typeOfRequest'] = 'TN';

        $this->_data = $this->_client->__soapCall('Air_MultiAvailability', $params, null,
            new \SoapHeader(Client::AMD_HEAD_NAMESPACE, 'SessionId', $this->_headers['SessionId']), $this->_headers);

        $this->debugDump($params, $this->_data);
    }

    /**
     * Air_MultiAvailability
     * Check airline availability by Service
     *
     * @param string $deprt_date Departure date
     * @param string $deprt_loc  Departure location
     * @param string $arrive_loc Arrival location
     * @param string $service    Class of service
     * @param string $air_code   Airline code
     * @param string $air_num    Airline number
     */
    public function airServiceAvailability($deprt_date, $deprt_loc, $arrive_loc, $service)
    {
        $params = array();
        $params['Air_MultiAvailability']['messageActionDetails']['functionDetails']['actionCode'] = 44;
        $params['Air_MultiAvailability']['requestSection']['availabilityProductInfo']['availabilityDetails']['departureDate'] = $deprt_date;
        $params['Air_MultiAvailability']['requestSection']['availabilityProductInfo']['departureLocationInfo']['cityAirport'] = $deprt_loc;
        $params['Air_MultiAvailability']['requestSection']['availabilityProductInfo']['arrivalLocationInfo']['cityAirport'] = $arrive_loc;
        $params['Air_MultiAvailability']['requestSection']['availabilityOptions']['productTypeDetails']['typeOfRequest'] = 'TN';
        $params['Air_MultiAvailability']['requestSection']['cabinOption']['cabinDesignation']['cabinClassOfServiceList'] = $service;

        $this->_data = $this->_client->__soapCall('Air_MultiAvailability', $params, null,
            new \SoapHeader(Client::AMD_HEAD_NAMESPACE, 'SessionId', $this->_headers['SessionId']), $this->_headers);

        $this->debugDump($params, $this->_data);
    }

    /**
     * Fare_MasterPricerTravelBoardSearch
     * Search for lowest fare
     *
     * @param string $deprt_date  Departure date
     * @param string $deprt_loc   Departure location
     * @param string $arrive_loc  Arrival location
     * @param array  $travellers  Travellers array
     * @param string $return_date Return date
     */
    public function fareMasterPricerTravelBoardSearch($deprt_date, $deprt_loc, $arrive_loc, $travellers, $return_date = null)
    {
        $params = array();
        $j = 0;
        $params['Fare_MasterPricerTravelBoardSearch']['numberOfUnit']['unitNumberDetail'][$j]['numberOfUnits'] = $travellers['A'] + $travellers['C'];
        $params['Fare_MasterPricerTravelBoardSearch']['numberOfUnit']['unitNumberDetail'][$j]['typeOfUnit'] = 'PX';
        $params['Fare_MasterPricerTravelBoardSearch']['numberOfUnit']['unitNumberDetail'][$j+1]['numberOfUnits'] = 200;
        $params['Fare_MasterPricerTravelBoardSearch']['numberOfUnit']['unitNumberDetail'][$j+1]['typeOfUnit'] = 'RC';
        $params['Fare_MasterPricerTravelBoardSearch']['paxReference'][$j]['ptc'] = 'ADT';

        for ($i = 1; $i <= $travellers['A']; $i++) {
            $params['Fare_MasterPricerTravelBoardSearch']['paxReference'][$j]['traveller'][]['ref'] = $i;
        }

        if ($travellers['C'] > 0) {
            $j++;
            $params['Fare_MasterPricerTravelBoardSearch']['paxReference'][$j]['ptc'] = 'CNN';
            for (; $i <= $travellers['C'] + $travellers['A']; $i++) {
                $params['Fare_MasterPricerTravelBoardSearch']['paxReference'][$j]['traveller'][]['ref'] = $i;
            }
        }

        if ($travellers['I'] > 0) {
            $j++;
            $k = 0;
            $params['Fare_MasterPricerTravelBoardSearch']['paxReference'][$j]['ptc'] = 'INF';
            for (; $i<=$travellers['I'] + $travellers['C'] + $travellers['A']; $i++) {
                $params['Fare_MasterPricerTravelBoardSearch']['paxReference'][$j]['traveller'][$k]['ref'] = $i;
                $params['Fare_MasterPricerTravelBoardSearch']['paxReference'][$j]['traveller'][$k]['infantIndicator'] = 1;
                $k++;
            }
        }

        $params['Fare_MasterPricerTravelBoardSearch']['fareOptions']['pricingTickInfo']['pricingTicketing']['priceType'] = 'ADI';
        $params['Fare_MasterPricerTravelBoardSearch']['fareOptions']['pricingTickInfo']['pricingTicketing']['priceType'] = 'TAC';
        $params['Fare_MasterPricerTravelBoardSearch']['fareOptions']['pricingTickInfo']['pricingTicketing']['priceType'] = 'RU';
        $params['Fare_MasterPricerTravelBoardSearch']['fareOptions']['pricingTickInfo']['pricingTicketing']['priceType'] = 'RP';

        $params['Fare_MasterPricerTravelBoardSearch']['itinerary'][0]['requestedSegmentRef']['segRef'] = 1;
        $params['Fare_MasterPricerTravelBoardSearch']['itinerary'][0]['departureLocalization']['depMultiCity']['locationId'] = $deprt_loc;
        $params['Fare_MasterPricerTravelBoardSearch']['itinerary'][0]['arrivalLocalization']['arrivalMultiCity']['locationId'] = $arrive_loc;
        $params['Fare_MasterPricerTravelBoardSearch']['itinerary'][0]['timeDetails']['firstDateTimeDetail']['date'] = $deprt_date;

        if ($return_date) {
            $params['Fare_MasterPricerTravelBoardSearch']['itinerary'][1]['requestedSegmentRef']['segRef'] = 2;
            $params['Fare_MasterPricerTravelBoardSearch']['itinerary'][1]['departureLocalization']['depMultiCity']['locationId'] = $arrive_loc;
            $params['Fare_MasterPricerTravelBoardSearch']['itinerary'][1]['arrivalLocalization']['arrivalMultiCity']['locationId'] = $deprt_loc;
            $params['Fare_MasterPricerTravelBoardSearch']['itinerary'][1]['timeDetails']['firstDateTimeDetail']['date'] = $return_date;
        }

        $this->_data = $this->_client->__soapCall('Fare_MasterPricerTravelBoardSearch', $params, null,
            new \SoapHeader(Client::AMD_HEAD_NAMESPACE, 'SessionId', $this->_headers['SessionId']), $this->_headers);

        $this->debugDump($params, $this->_data);
    }

    /**
     * pnrAddMultiElements
     * Make reservation call
     *
     * @param array $travellers Travellers array
     */
    public function pnrAddMultiElements($travellers)
    {
        $adults = count($travellers['A']);
        $children = count($travellers['C']);
        $infants = count($travellers['I']);
        $total_passengers = $adults + $children + $infants;
        $params = array();
        $params['PNR_AddMultiElements']['pnrActions']['optionCode'] = 0;

        $i = 0;
        $inf = 0;
        foreach ($travellers['A'] as $adult) {
            $trav = 0;
            $params['PNR_AddMultiElements']['travellerInfo'][$i]['elementManagementPassenger']['reference']['qualifier'] = 'PR';
            $params['PNR_AddMultiElements']['travellerInfo'][$i]['elementManagementPassenger']['reference']['number'] = $i+1;
            $params['PNR_AddMultiElements']['travellerInfo'][$i]['elementManagementPassenger']['segmentName'] = 'NM';

            $params['PNR_AddMultiElements']['travellerInfo'][$i]['passengerData']['travellerInformation']['traveller']['surname'] = $adult['surname'];
            $params['PNR_AddMultiElements']['travellerInfo'][$i]['passengerData']['travellerInformation']['traveller']['quantity'] = 1;
            $params['PNR_AddMultiElements']['travellerInfo'][$i]['passengerData']['travellerInformation']['passenger'][$trav]['firstName'] = $adult['first_name'];
            $params['PNR_AddMultiElements']['travellerInfo'][$i]['passengerData']['travellerInformation']['passenger'][$trav]['type'] = 'ADT';

            if ($infants > 0) {
                $params['PNR_AddMultiElements']['travellerInfo'][$i]['passengerData']['travellerInformation']['passenger'][$trav]['infantIndicator'] = 2;
                $trav++;
                $params['PNR_AddMultiElements']['travellerInfo'][$i]['passengerData']['travellerInformation']['passenger'][$trav]['firstName'] = $travellers['I'][$inf]['first_name'];
                $params['PNR_AddMultiElements']['travellerInfo'][$i]['passengerData']['travellerInformation']['passenger'][$trav]['type'] = 'INF';
                $infants--;
                $inf++;
            }
            $i++;
        }

        if ($children > 0) {
            foreach ($travellers['C'] as $child) {
                $trav = 0;
                $params['PNR_AddMultiElements']['travellerInfo'][$i]['elementManagementPassenger']['reference']['qualifier'] = 'PR';
                $params['PNR_AddMultiElements']['travellerInfo'][$i]['elementManagementPassenger']['reference']['number'] = $i+1;
                $params['PNR_AddMultiElements']['travellerInfo'][$i]['elementManagementPassenger']['segmentName'] = 'NM';

                $params['PNR_AddMultiElements']['travellerInfo'][$i]['passengerData']['travellerInformation']['traveller']['surname'] = $child['surname'];
                $params['PNR_AddMultiElements']['travellerInfo'][$i]['passengerData']['travellerInformation']['traveller']['quantity'] = 1;
                $params['PNR_AddMultiElements']['travellerInfo'][$i]['passengerData']['travellerInformation']['passenger'][$trav]['firstName'] = $child['first_name'];
                $params['PNR_AddMultiElements']['travellerInfo'][$i]['passengerData']['travellerInformation']['passenger'][$trav]['type'] = 'CHD';

                $i++;
            }
        }

        $j = 0;
        $params['PNR_AddMultiElements']['dataElementsMaster']['marker1'] = null;
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['elementManagementData']['reference']['qualifier'] = 'OT';
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['elementManagementData']['reference']['number'] = 1;
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['elementManagementData']['segmentName'] = 'RF';
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['freetextData']['freetextDetail']['subjectQualifier']= 3;
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['freetextData']['freetextDetail']['type']= 'P22';
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['freetextData']['longFreetext'] = 'Received From Whoever';

        $j++;
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['elementManagementData']['reference']['qualifier'] = 'OT';
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['elementManagementData']['reference']['number'] = 2;
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['elementManagementData']['segmentName'] = 'TK';
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['ticketElement']['ticket']['indicator']= 'OK';

        $j++;
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['elementManagementData']['reference']['qualifier'] = 'OT';
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['elementManagementData']['reference']['number'] = 3;
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['elementManagementData']['segmentName'] = 'ABU';
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['freetextData']['freetextDetail']['subjectQualifier']= 3;
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['freetextData']['freetextDetail']['type']= 2;
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['freetextData']['longFreetext'] = 'MR ESTEBAN LORENZO, BUCKINGHAM PALACE, LONDON, N1 1BP, UK';

        $j++;
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['elementManagementData']['reference']['qualifier'] = 'OT';
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['elementManagementData']['reference']['number'] = 4;
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['elementManagementData']['segmentName'] = 'AP';
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['freetextData']['freetextDetail']['subjectQualifier']= 3;
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['freetextData']['freetextDetail']['type']= 5;
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['freetextData']['longFreetext'] = '012345 678910';

        $this->_data = $this->_client->__soapCall('PNR_AddMultiElements', $params, null,
            new \SoapHeader(Client::AMD_HEAD_NAMESPACE, 'SessionId', $this->_headers['SessionId']), $this->_headers);

        $this->debugDump($params, $this->_data);
    }

    /**
     * Air_SellFromRecommendation
     * Set travel segments
     *
     * @param string $from     Boarding point
     * @param string $to       Destination
     * @param array  $segments Travel Segments
     */
    public function airSellFromRecommendation($from, $to, $segments)
    {
        $params = array();
        $params['Air_SellFromRecommendation']['messageActionDetails']['messageFunctionDetails']['messageFunction'] = 183;
        $params['Air_SellFromRecommendation']['messageActionDetails']['messageFunctionDetails']['additionalMessageFunction'] = 'M1';
        $params['Air_SellFromRecommendation']['itineraryDetails']['originDestinationDetails']['origin'] = $from;
        $params['Air_SellFromRecommendation']['itineraryDetails']['originDestinationDetails']['destination'] = $to;
        $params['Air_SellFromRecommendation']['itineraryDetails']['message']['messageFunctionDetails']['messageFunction'] = 183;

        $i = 0;
        foreach ($segments as $segment) {
            $params['Air_SellFromRecommendation']['itineraryDetails']['segmentInformation'][$i]['travelProductInformation']['flightDate']['departureDate'] = $segment['dep_date'];
            $params['Air_SellFromRecommendation']['itineraryDetails']['segmentInformation'][$i]['travelProductInformation']['boardPointDetails']['trueLocationId'] = $segment['dep_location'];
            $params['Air_SellFromRecommendation']['itineraryDetails']['segmentInformation'][$i]['travelProductInformation']['offpointDetails']['trueLocationId'] = $segment['dest_location'];
            $params['Air_SellFromRecommendation']['itineraryDetails']['segmentInformation'][$i]['travelProductInformation']['companyDetails']['marketingCompany'] = $segment['company'];
            $params['Air_SellFromRecommendation']['itineraryDetails']['segmentInformation'][$i]['travelProductInformation']['flightIdentification']['flightNumber'] = $segment['flight_no'];
            $params['Air_SellFromRecommendation']['itineraryDetails']['segmentInformation'][$i]['travelProductInformation']['flightIdentification']['bookingClass'] = $segment['class'];
            $params['Air_SellFromRecommendation']['itineraryDetails']['segmentInformation'][$i]['relatedproductInformation']['quantity'] = $segment['passengers'];
            $params['Air_SellFromRecommendation']['itineraryDetails']['segmentInformation'][$i]['relatedproductInformation']['statusCode'] = 'NN';
            $i++;
        }

        $this->_data = $this->_client->__soapCall('Air_SellFromRecommendation', $params, null,
            new \SoapHeader(Client::AMD_HEAD_NAMESPACE, 'SessionId', $this->_headers['SessionId']), $this->_headers);

        $this->debugDump($params, $this->_data);
    }

    /**
     * Fare_PricePNRWithBookingClass
     *
     * @param string $code Carrier code
     */
    public function farePricePNRWithBookingClass($code = null)
    {
        $params = array();
        $params['Fare_PricePNRWithBookingClass']['overrideInformation']['attributeDetails'][0]['attributeType'] = 'RLO';
        $params['Fare_PricePNRWithBookingClass']['overrideInformation']['attributeDetails'][1]['attributeType'] = 'RP';
        $params['Fare_PricePNRWithBookingClass']['overrideInformation']['attributeDetails'][2]['attributeType'] = 'RU';
        //$params['Fare_PricePNRWithBookingClass']['overrideInformation']['validatingCarrier']['carrierInformation']['carrierCode'] = $code;

        $this->_data = $this->_client->__soapCall('Fare_PricePNRWithBookingClass', $params, null,
            new \SoapHeader(Client::AMD_HEAD_NAMESPACE, 'SessionId', $this->_headers['SessionId']), $this->_headers);

        $this->debugDump($params, $this->_data);
    }

    /**
     * Ticket_CreateTSTFromPricing
     *
     * @param integer $types Number of passenger types
     */
    public function ticketCreateTSTFromPricing($types)
    {
        $params = array();

        for ($i = 0; $i < $types; $i++) {
            $params['Ticket_CreateTSTFromPricing']['psaList'][$i]['itemReference']['referenceType'] = 'TST';
            $params['Ticket_CreateTSTFromPricing']['psaList'][$i]['itemReference']['uniqueReference'] = $i+1;
        }

        $this->_data = $this->_client->__soapCall('Ticket_CreateTSTFromPricing', $params, null,
            new \SoapHeader(Client::AMD_HEAD_NAMESPACE, 'SessionId', $this->_headers['SessionId']), $this->_headers);

        $this->debugDump($params, $this->_data);
    }

    /**
    * PNR_AddMultiElements
    * Final save operation
    */
    public function pnrAddMultiElementsFinal()
    {
        $params = array();
        $params['PNR_AddMultiElements']['pnrActions']['optionCode'] = 11;

        $this->_data = $this->_client->__soapCall('PNR_AddMultiElements', $params, null,
            new \SoapHeader(Client::AMD_HEAD_NAMESPACE, 'SessionId', $this->_headers['SessionId']), $this->_headers);

        $this->debugDump($params, $this->_data);
    }

    /**
     * PNR_Retrieve
     * Get PNR by id
     *
     * @param string $pnr_id PNR ID
     */
    public function pnrRetrieve($pnr_id)
    {
        $params = array();
        $params['PNR_Retrieve']['retrievalFacts']['retrieve']['type'] = 2;
        $params['PNR_Retrieve']['retrievalFacts']['reservationOrProfileIdentifier']['reservation']['controlNumber'] = $pnr_id;

        $this->_data = $this->_client->__soapCall('PNR_Retrieve', $params, null,
            new \SoapHeader(Client::AMD_HEAD_NAMESPACE, 'SessionId', $this->_headers['SessionId']), $this->_headers);

        $this->debugDump($params, $this->_data);
    }

    /**
     * Recusively dump the variable
     *
     * @param string $varname Name of the variable
     * @param mixed  $varval  Vriable to be dumped
     */
    private function dumpVariable($varname, $varval)
    {
        if (! is_array($varval) && ! is_object($varval)) {
            print $varname . ' = ' . $varval . "<br>\n";
        } else {
            print $varname . " = data()<br>\n";
            foreach ($varval as $key => $val) {
                $this->dumpVariable($varname . "['" . $key . "']", $val);
            }
        }
    }

    /**
     * Dump the variables in debug mode
     *
     * @param array $params The parameters used
     * @param array $data   The response data
     */
    private function debugDump($params, $data)
    {
        if ($this->_debug) {
            // Request and Response
            $this->dumpVariable('', $params);
            $this->dumpVariable('data', $data);

            // Trace output
            print "<br />Request Trace:<br />";
            var_dump($this->_client->__getLastRequest());
            print "<br />Response Trace:<br />";
            var_dump($this->_client->__getLastResponse());
        }
    }
}
