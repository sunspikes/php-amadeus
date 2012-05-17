<?php
/**
 * Copyright (c) 2011, Krishnaprasad MG
 * All rights reserved.
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in the
 *     documentation and/or other materials provided with the distribution.
 *   * Neither the name of the the author nor the
 *     names of its contributors may be used to endorse or promote products
 *     derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

/**
 * Amadeus Flight Search & Booking Class
 * This class provides PHP implementation of Amadeus Flight Booking and Search API
 *
 * @see https://extranets.us.amadeus.com
 */
class Amadeus {
  
  const AMD_HEAD_NAMESPACE =  'http://webservices.amadeus.com/definitions';
  
  private $_data = null;
  private $_headers = null;
  private $_client = null;
  private $_debug = false;
  
  /**
   * Constructor
   */
  public function __construct($wsdl, $debug = false) {
    $this->_debug = $debug;
    $this->_client = new SoapClient($wsdl, array('trace'=> $debug));
  } 
  
  /**
   * Get response data
   */
  public function getData() {
    return $this->_data;
  }
  
  /**
   * Get response headers
   */
  public function getHeaders() {
    return $this->_headers;
  }

  /**
   * Security_Authenticate
   * Autheticates with Amadeus
   * 
   * @param $source
   * 		  sourceOffice string 
   * @param $origin
   * 		  originator string
   * @param $password
   * 		  password binaryData
   * @param $passlen
   * 		  length of binaryData
   * @param $org
   * 		  organizationId string
   */
  public function securityAuthenticate($source, $origin, $password, $passlen, $org) {
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
    
    $this->_data = $this->_client->__soapCall('Security_Authenticate', $params, NULL, new SoapHeader(AMD_HEAD_NAMESPACE, 'SessionId', NULL), $this->_headers);
    
     $this->_debugDump($params, $this->_data);
  }
  
  /**
   * Security_SignOut 
   * Signs out from Amadeus
   */
  public function securitySignout() {
    $params = array();
    $params['Security_SignOut']['SessionId'] = $this->_headers['SessionId'];

    $this->_data = $this->_client->__soapCall('Security_SignOut', $params, NULL, new SoapHeader(AMD_HEAD_NAMESPACE, 'SessionId', $this->_headers['SessionId']), $this->_headers);
    
    $this->_debugDump($params, $this->_data);
  }
  
  /**
   * Command_Cryptic
   * 
   * @param $string
   * 		  The string to be sent
   */
  public function commandCryptic($string) {
    $params = array();
    $params['Command_Cryptic']['longTextString']['textStringDetails'] = $string;
    $params['Command_Cryptic']['messageAction']['messageFunctionDetails']['messageFunction'] = 'M';
    
    $this->_data = $this->_client->__soapCall('Command_Cryptic', $params, NULL, new SoapHeader(AMD_HEAD_NAMESPACE, 'SessionId', $this->_headers['SessionId']), $this->_headers);
    
    $this->_debugDump($params, $this->_data);
  }
  
  /**
   * Air_MultiAvailability
   * Check airline availability by Flight
   * 
   * @param $deprt_date
   * 		  Departure date
   * @param $deprt_loc
   * 		  Departure location
   * @param $arrive_loc
   * 		  Arrival location
   * @param $service
   * 		  Class of service
   * @param $air_code
   * 		  Airline code
   * @param $air_num
   * 		  Airline number
   */
  public function airFlightAvailability($deprt_date, $deprt_loc, $arrive_loc, $service, $air_code, $air_num) {
    $params = array();
    $params['Air_MultiAvailability']['messageActionDetails']['functionDetails']['actionCode'] = 44;
    $params['Air_MultiAvailability']['requestSection']['availabilityProductInfo']['availabilityDetails']['departureDate'] = $deprt_date;
    $params['Air_MultiAvailability']['requestSection']['availabilityProductInfo']['departureLocationInfo']['cityAirport'] = $deprt_loc;
    $params['Air_MultiAvailability']['requestSection']['availabilityProductInfo']['arrivalLocationInfo']['cityAirport'] = $arrive_loc;
    $params['Air_MultiAvailability']['requestSection']['optionClass']['productClassDetails']['serviceClass'] = $service;
    $params['Air_MultiAvailability']['requestSection']['airlineOrFlightOption']['flightIdentification']['airlineCode'] = $air_code;
    $params['Air_MultiAvailability']['requestSection']['airlineOrFlightOption']['flightIdentification']['number'] = $air_num;
    $params['Air_MultiAvailability']['requestSection']['availabilityOptions']['productTypeDetails']['typeOfRequest'] = 'TN';
    
    $this->_data = $this->_client->__soapCall('Air_MultiAvailability', $params, NULL, new SoapHeader(AMD_HEAD_NAMESPACE, 'SessionId', $this->_headers['SessionId']), $this->_headers);
    
    $this->_debugDump($params, $this->_data);
  }

  /**
   * Air_MultiAvailability
   * Check airline availability by Service
   * 
   * @param $deprt_date
   * 		  Departure date
   * @param $deprt_loc
   * 		  Departure location
   * @param $arrive_loc
   * 		  Arrival location
   * @param $service
   * 		  Class of service
   * @param $air_code
   * 		  Airline code
   * @param $air_num
   * 		  Airline number
   */
  public function airServiceAvailability($deprt_date, $deprt_loc, $arrive_loc, $service) {
    $params = array();
    $params['Air_MultiAvailability']['messageActionDetails']['functionDetails']['actionCode'] = 44;
    $params['Air_MultiAvailability']['requestSection']['availabilityProductInfo']['availabilityDetails']['departureDate'] = $deprt_date;
    $params['Air_MultiAvailability']['requestSection']['availabilityProductInfo']['departureLocationInfo']['cityAirport'] = $deprt_loc;
    $params['Air_MultiAvailability']['requestSection']['availabilityProductInfo']['arrivalLocationInfo']['cityAirport'] = $arrive_loc;
    $params['Air_MultiAvailability']['requestSection']['availabilityOptions']['productTypeDetails']['typeOfRequest'] = 'TN';
    $params['Air_MultiAvailability']['requestSection']['cabinOption']['cabinDesignation']['cabinClassOfServiceList'] = $service;
    
    $this->_data = $this->_client->__soapCall('Air_MultiAvailability', $params, NULL, new SoapHeader(AMD_HEAD_NAMESPACE, 'SessionId', $this->_headers['SessionId']), $this->_headers);
    
    $this->_debugDump($params, $this->_data);
  }

  /**
   * Fare_MasterPricerTravelBoardSearch
   * Search for lowest fare
   * 
   * @param $deprt_date
   * 		  Departure date
   * @param $deprt_loc
   * 		  Departure location
   * @param $arrive_loc
   * 		  Arrival location
   * @param $travellers
   * 		  Travellers array
   *      @example
   *      $travellers['A'] = array( array('surname' => 'DOE', 'first_name' => 'JOHN') );
   *      $travellers['C'] = array( array('surname' => 'DWYNE', 'first_name' => 'JOHNSON') );
   *      $travellers['I'] = array();
   * @param $return_date
   * 		  Return date
   */
  public function fareMasterPricerTravelBoardSearch($deprt_date, $deprt_loc, $arrive_loc, $travellers, $return_date = null) {
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
      for (;$i <= $travellers['C'] + $travellers['A']; $i++) {
        $params['Fare_MasterPricerTravelBoardSearch']['paxReference'][$j]['traveller'][]['ref'] = $i;
      }
    }
    
    if ($travellers['I'] > 0) {
      $j++;
      $k = 0;
      $params['Fare_MasterPricerTravelBoardSearch']['paxReference'][$j]['ptc'] = 'INF';
      for (;$i<=$travellers['I'] + $travellers['C'] + $travellers['A']; $i++) {
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
    
    $this->_data = $this->_client->__soapCall('Fare_MasterPricerTravelBoardSearch', $params, NULL, new SoapHeader(AMD_HEAD_NAMESPACE, 'SessionId', $this->_headers['SessionId']), $this->_headers);
        
    $this->_debugDump($params, $this->_data);
  } 
    
  
  /**
   * pnrAddMultiElements
   * Make reservation call
   * 
   * @param $travellers
   * 		  Travellers array
   *      @example
   *      $travellers['A'] = array( array('surname' => 'DOE', 'first_name' => 'JOHN') );
   *      $travellers['C'] = array( array('surname' => 'DWYNE', 'first_name' => 'JOHNSON') );
   *      $travellers['I'] = array();
   */
  public function pnrAddMultiElements($travellers) {
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
		$params['PNR_AddMultiElements']['dataElementsMaster']['marker1'] = NULL;
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
		
    $this->_data = $this->_client->__soapCall('PNR_AddMultiElements', $params, NULL, new SoapHeader(AMD_HEAD_NAMESPACE, 'SessionId', $this->_headers['SessionId']), $this->_headers);
    
    $this->_debugDump($params, $this->_data);
  }
  
  
  /**
   * Air_SellFromRecommendation
   * Set travel segments
   * 
   * @param $from
   * 		  Boarding point
   * @param $to
   * 		  Destination
   * @param $segments
   * 		  Travel Segments
   */
  public function airSellFromRecommendation($from, $to, $segments) {
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
    
    $this->_data = $this->_client->__soapCall('Air_SellFromRecommendation', $params, NULL, new SoapHeader(AMD_HEAD_NAMESPACE, 'SessionId', $this->_headers['SessionId']), $this->_headers);
    
    $this->_debugDump($params, $this->_data);
  }

  /**
   * Fare_PricePNRWithBookingClass
   * 
   * @param $code
   * 		  Carrier code
   */
  public function farePricePNRWithBookingClass($code = NULL) {
	  $params = array();
		$params['Fare_PricePNRWithBookingClass']['overrideInformation']['attributeDetails'][0]['attributeType'] = 'RLO';
		$params['Fare_PricePNRWithBookingClass']['overrideInformation']['attributeDetails'][1]['attributeType'] = 'RP';
		$params['Fare_PricePNRWithBookingClass']['overrideInformation']['attributeDetails'][2]['attributeType'] = 'RU';
		//$params['Fare_PricePNRWithBookingClass']['overrideInformation']['validatingCarrier']['carrierInformation']['carrierCode'] = $code;
      
		$this->_data = $this->_client->__soapCall('Fare_PricePNRWithBookingClass', $params, NULL, new SoapHeader(AMD_HEAD_NAMESPACE, 'SessionId', $this->_headers['SessionId']), $this->_headers);
		
    $this->_debugDump($params, $this->_data);
	}

  /**
   * Ticket_CreateTSTFromPricing
   * 
   * @param $types
   * 		  Number of passenger types
   */
	public function ticketCreateTSTFromPricing($types) {
	  $params = array();
		
		for($i = 0; $i < $types; $i++) {
		  $params['Ticket_CreateTSTFromPricing']['psaList'][$i]['itemReference']['referenceType'] = 'TST';
			$params['Ticket_CreateTSTFromPricing']['psaList'][$i]['itemReference']['uniqueReference'] = $i+1;
		}
		      
    $this->_data = $this->_client->__soapCall('Ticket_CreateTSTFromPricing', $params, NULL, new SoapHeader(AMD_HEAD_NAMESPACE, 'SessionId', $this->_headers['SessionId']), $this->_headers);
    
    $this->_debugDump($params, $this->_data);
  }

  /**
   * PNR_AddMultiElements
   * Final save operation
   */
  public function pnrAddMultiElementsFinal() {
    $params = array();
    $params['PNR_AddMultiElements']['pnrActions']['optionCode'] = 11;
      
	  $this->_data = $this->_client->__soapCall('PNR_AddMultiElements', $params, NULL, new SoapHeader(AMD_HEAD_NAMESPACE, 'SessionId', $this->_headers['SessionId']), $this->_headers);
	  
    $this->_debugDump($params, $this->_data);
  }
  
  /**
   * PNR_Retrieve
   * Get PNR by id
   *
   * @param $pnr_id
   *        PNR ID
   */
	public function pnrRetrieve($pnr_id) {
    $params = array();
    $params['PNR_Retrieve']['retrievalFacts']['retrieve']['type'] = 2;
    $params['PNR_Retrieve']['retrievalFacts']['reservationOrProfileIdentifier']['reservation']['controlNumber'] = $pnr_id;

	  $this->_data = $this->_client->__soapCall('PNR_Retrieve', $params, NULL, new SoapHeader(AMD_HEAD_NAMESPACE, 'SessionId', $this->_headers['SessionId']), $this->_headers);
    
    $this->_debugDump($params, $this->_data);
  }
  
  /**
   * Recusively dump the variable
   */
  private function _dumpVariable($varname, $varval) {
    if (! is_array($varval) && ! is_object($varval)) {
      print $varname . ' = ' . $varval . "<br>\n";
    }
    else {
      print $varname . " = data()<br>\n";
      foreach ($varval as $key => $val) {
        $this->_dumpVariable($varname . "['" . $key . "']", $val);
      }
    }
  }
  
  /**
   * Dump the variables in debug mode
   */
  private function _debugDump($params, $data) {
    if($this->_debug) {
      // Request and Response
      $this->_dumpVariable('', $params);
      $this->_dumpVariable('data', $data);
      
      // Trace output
      print "<br />Request Trace:<br />";
      var_dump($this->_client->__getLastRequest());
      print "<br />Response Trace:<br />";
      var_dump($this->_client->__getLastResponse());
    }
  }
}
