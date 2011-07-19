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
 * Amadeus Flight Class
 */
class Amadeus
{
  const AMD_HEAD_NAMESPACE =  'http://webservices.amadeus.com/definitions';
  
  private $_client = null;
  private $_headers = null;
  private $_data = null;
  private $_debug = false;

  public function __construct($wsdl, $debug=false) {
    $this->_debug = $debug;
    $this->_client = new SoapClient($wsdl, array('trace' => $debug));
  }
  
  public function getData() {
    return $this->_data;
  }
  
  public function getHeaders() {
    return $this->_headers;
  }
  
  public function _dumpVariable($varname, $varval) {
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
  public function debugDump($params, $data) {
    if($this->_debug) {
      $this->_dumpVariable('', $params);
      $this->_dumpVariable('data', $data);
    }
  }
  
  /**
   * Security_Authenticate
   * Autheticates the application with Amadeus
   */
  public function securityAuthenticate($source, $origin, $password, $passlen, $org_id) {
    $params = array();
    $params['Security_Authenticate']['userIdentifier']['originIdentification']['sourceOffice'] = $source;
    $params['Security_Authenticate']['userIdentifier']['originatorTypeCode'] = 'U'; 
    $params['Security_Authenticate']['userIdentifier']['originator'] = $origin; 
    $params['Security_Authenticate']['dutyCode']['dutyCodeDetails']['referenceQualifier'] = 'DUT'; 
    $params['Security_Authenticate']['dutyCode']['dutyCodeDetails']['referenceIdentifier'] = 'SU'; 
    $params['Security_Authenticate']['systemDetails']['organizationDetails']['organizationId'] = $org_id; 
    $params['Security_Authenticate']['passwordInfo']['dataLength'] = $passlen; 
    $params['Security_Authenticate']['passwordInfo']['dataType'] = 'E'; 
    $params['Security_Authenticate']['passwordInfo']['binaryData'] = $password;
    
    $this->_data = $this->_client->__soapCall('Security_Authenticate', $params, NULL, new SoapHeader(AMD_HEAD_NAMESPACE, 'SessionId', NULL), $this->_headers);
    debugDump($params, $this->_data);
  }
    
    /**
     * Air_MultiAvailability
     * Check airline availability for a particulat flight on a date
     */
    public function airMultiAvailability($deprt_date, $deprt_loc, $arrive_loc, $service, $air_code, $air_num) {
      $params = array();
      $params['Air_MultiAvailability']['messageActionDetails']['functionDetails']['actionCode'] = 44;
      $params['Air_MultiAvailability']['requestSection']['availabilityProductInfo']['availabilityDetails']['departureDate'] = $deprt_date;
      $params['Air_MultiAvailability']['requestSection']['availabilityProductInfo']['departureLocationInfo']['cityAirport'] = $deprt_loc;
      $params['Air_MultiAvailability']['requestSection']['availabilityProductInfo']['arrivalLocationInfo']['cityAirport'] = $arrive_loc;
      $params['Air_MultiAvailability']['requestSection']['airlineOrFlightOption']['flightIdentification']['airlineCode'] = $air_code;
      $params['Air_MultiAvailability']['requestSection']['airlineOrFlightOption']['flightIdentification']['number'] = $air_num;
      $params['Air_MultiAvailability']['requestSection']['availabilityOptions']['productTypeDetails']['typeOfRequest'] = 'TD';
      $params['Air_MultiAvailability']['requestSection']['cabinOption']['cabinDesignation']['cabinClassOfServiceList'] = $service;
        
      $this->_data = $this->_client->__soapCall('Air_MultiAvailability', $params, NULL, new SoapHeader(AMD_HEAD_NAMESPACE, 'SessionId', $this->_headers['SessionId']), $this->_headers);
      debugDump($params, $this->_data);
    }
    
    /**
     * Air_MultiAvailability
     * Check airline availability for a date
     */
    public function airCheckAvailability($deprt_date, $deprt_loc, $arrive_loc, $service) {
      $params = array();
      $params['Air_MultiAvailability']['messageActionDetails']['functionDetails']['actionCode'] = 44;
      $params['Air_MultiAvailability']['requestSection']['availabilityProductInfo']['availabilityDetails']['departureDate'] = $deprt_date;
      $params['Air_MultiAvailability']['requestSection']['availabilityProductInfo']['departureLocationInfo']['cityAirport'] = $deprt_loc;
      $params['Air_MultiAvailability']['requestSection']['availabilityProductInfo']['arrivalLocationInfo']['cityAirport'] = $arrive_loc;
      $params['Air_MultiAvailability']['requestSection']['availabilityOptions']['productTypeDetails']['typeOfRequest'] = 'TD';
      $params['Air_MultiAvailability']['requestSection']['cabinOption']['cabinDesignation']['cabinClassOfServiceList'] = $service;
        
      $this->_data = $this->_client->__soapCall('Air_MultiAvailability', $params, NULL, new SoapHeader(AMD_HEAD_NAMESPACE, 'SessionId', $this->_headers['SessionId']), $this->_headers);
      debugDump($params, $this->_data);
    }
    
    /**
     * Fare_MasterPricerTravelBoardSearch
     * Search for lowest fare
     */
    public function fareMasterPricerTravelBoardSearch($deprt_date, $deprt_loc, $arrive_loc, $travellers, $return_date=null, $class=null) {
      $params = array();
      $j = 0;
      $params['Fare_MasterPricerTravelBoardSearch']['numberOfUnit']['unitNumberDetail'][$j]['numberOfUnits'] = $travellers['A'] + $travellers['C'];
      $params['Fare_MasterPricerTravelBoardSearch']['numberOfUnit']['unitNumberDetail'][$j]['typeOfUnit'] = 'PX';
      $params['Fare_MasterPricerTravelBoardSearch']['numberOfUnit']['unitNumberDetail'][$j+1]['numberOfUnits'] = 200;
      $params['Fare_MasterPricerTravelBoardSearch']['numberOfUnit']['unitNumberDetail'][$j+1]['typeOfUnit'] = 'RC';
      $params['Fare_MasterPricerTravelBoardSearch']['paxReference'][$j]['ptc'] = 'ADT';
      for($i=1; $i<=$travellers['A']; $i++) {
        $params['Fare_MasterPricerTravelBoardSearch']['paxReference'][$j]['traveller'][]['ref'] = $i;
      }
      
      if($travellers['C'] > 0) {
        $j++;
        $params['Fare_MasterPricerTravelBoardSearch']['paxReference'][$j]['ptc'] = 'CH';
        for(;$i<=$travellers['C']+$travellers['A']; $i++) {
          $params['Fare_MasterPricerTravelBoardSearch']['paxReference'][$j]['traveller'][]['ref'] = $i;
        }
      }
      
      if($travellers['I'] > 0) {
        $j++;
        $k = 0;
        $params['Fare_MasterPricerTravelBoardSearch']['paxReference'][$j]['ptc'] = 'INF';
        for(;$i<=$travellers['I']+$travellers['C']+$travellers['A']; $i++) {
          $params['Fare_MasterPricerTravelBoardSearch']['paxReference'][$j]['traveller'][$k]['ref'] = $i;
          $params['Fare_MasterPricerTravelBoardSearch']['paxReference'][$j]['traveller'][$k]['infantIndicator'] = 1;
          $k++;
        }
      }
      
      if($class) {
        $params['Fare_MasterPricerTravelBoardSearch']['travelFlightInfo']['cabinId']['cabinQualifier'] = 'MC';
	    $params['Fare_MasterPricerTravelBoardSearch']['travelFlightInfo']['cabinId']['cabin'] = $class;
      }
      $params['Fare_MasterPricerTravelBoardSearch']['fareOptions']['pricingTickInfo']['pricingTicketing']['priceType'] = 'ADI';
      $params['Fare_MasterPricerTravelBoardSearch']['fareOptions']['pricingTickInfo']['pricingTicketing']['priceType'] = 'TAC';
      $params['Fare_MasterPricerTravelBoardSearch']['fareOptions']['pricingTickInfo']['pricingTicketing']['priceType'] = 'RU';
      $params['Fare_MasterPricerTravelBoardSearch']['fareOptions']['pricingTickInfo']['pricingTicketing']['priceType'] = 'RP';
        
      $params['Fare_MasterPricerTravelBoardSearch']['itinerary'][0]['requestedSegmentRef']['segRef'] = 1;
      $params['Fare_MasterPricerTravelBoardSearch']['itinerary'][0]['departureLocalization']['depMultiCity']['locationId'] = $deprt_loc;
      $params['Fare_MasterPricerTravelBoardSearch']['itinerary'][0]['arrivalLocalization']['arrivalMultiCity']['locationId'] = $arrive_loc;
      $params['Fare_MasterPricerTravelBoardSearch']['itinerary'][0]['timeDetails']['firstDateTimeDetail']['date'] = $deprt_date;
      
      if($return_date) {
        $params['Fare_MasterPricerTravelBoardSearch']['itinerary'][1]['requestedSegmentRef']['segRef'] = 2;
        $params['Fare_MasterPricerTravelBoardSearch']['itinerary'][1]['departureLocalization']['depMultiCity']['locationId'] = $arrive_loc;
        $params['Fare_MasterPricerTravelBoardSearch']['itinerary'][1]['arrivalLocalization']['arrivalMultiCity']['locationId'] = $deprt_loc;
        $params['Fare_MasterPricerTravelBoardSearch']['itinerary'][1]['timeDetails']['firstDateTimeDetail']['date'] = $return_date;
      }
      $this->_data = $this->_client->__soapCall('Fare_MasterPricerTravelBoardSearch', $params, NULL, new SoapHeader(AMD_HEAD_NAMESPACE, 'SessionId', $this->_headers['SessionId']), $this->_headers);
      debugDump($params, $this->_data);
    }
    
    /**
     * PNR_AddMultiElements 
     * Make reservation call
     * 
     * @param $travellers
     * 		Travellers array
     * 
     * 		Example:
     * 		$travellers['A'] = array( array('surname' => 'DOE', 'first_name' => 'JOHN') );
	 *		$travellers['C'] = array( array('surname' => 'DWYNE', 'first_name' => 'JOHNSON') );
	 *		$travellers['I'] = array();
     * @param $onward
     * 		Onward segments array
     * 	
     * 		Example:
     * 		$onward['origin'] = 'IOM';
	 *		$onward['destination'] = 'JFK';
	 *		$onward['itinerary'][] = array('date' => '230111', 'from' => 'IOM', 'to' => 'GLA', 'company' => 'BE', 'code' => '6812', 'class' => 'M');
	 *		$onward['itinerary'][] = array('date' => '240111', 'from' => 'GLA', 'to' => 'LHR', 'company' => 'BA', 'code' => '1475', 'class' => 'M');
	 *		$onward['itinerary'][] = array('date' => '240111', 'from' => 'LHR', 'to' => 'JFK', 'company' => 'BA', 'code' => '6140', 'class' => 'M');
     * @param $return
     * 		Return segments array in the same format as $onward
     */
    public function pnrAddMultiElements($travellers, $onward, $return=array()) {
      $adults = count($travellers['A']);
      $children = count($travellers['C']);
      $infants = count($travellers['I']);
      $total_passengers = $adults + $children + $infants;
      $params = array();
      $params['PNR_AddMultiElements']['pnrActions']['optionCode'] = 0;
      $params['PNR_AddMultiElements']['travellerInfo']['elementManagementPassenger']['reference']['qualifier'] = 'PR';
      $params['PNR_AddMultiElements']['travellerInfo']['elementManagementPassenger']['reference']['number'] = $total_passengers;
      $params['PNR_AddMultiElements']['travellerInfo']['elementManagementPassenger']['segmentName'] = 'NM';
        
      $i = 0;
      foreach($travellers['A'] as $adult) {
        $params['PNR_AddMultiElements']['travellerInfo']['passengerData'][$i]['travellerInformation']['traveller']['surname'] = $adult['surname'];
        $qty = 1;
        if($i == 0 && $infants > 0) {
          $qty = 2;
          $infants--;
          $params['PNR_AddMultiElements']['travellerInfo']['passengerData'][$i]['travellerInformation']['passenger']['infantIndicator'] = 1;
        }
        $params['PNR_AddMultiElements']['travellerInfo']['passengerData'][$i]['travellerInformation']['traveller']['quantity'] = $qty;
        $params['PNR_AddMultiElements']['travellerInfo']['passengerData'][$i]['travellerInformation']['passenger']['firstName'] = $adult['first_name'];
        $params['PNR_AddMultiElements']['travellerInfo']['passengerData'][$i]['travellerInformation']['passenger']['type'] = 'ADT';
        $i++;
      }
        
      if($children > 0) {
        foreach($travellers['C'] as $child) {
          $params['PNR_AddMultiElements']['travellerInfo']['passengerData'][$i]['travellerInformation']['traveller']['surname'] = $child['surname'];
          $params['PNR_AddMultiElements']['travellerInfo']['passengerData'][$i]['travellerInformation']['traveller']['quantity'] = 1;
          $params['PNR_AddMultiElements']['travellerInfo']['passengerData'][$i]['travellerInformation']['passenger']['firstName'] = $child['first_name'];
          $params['PNR_AddMultiElements']['travellerInfo']['passengerData'][$i]['travellerInformation']['passenger']['type'] = 'CHD';
          $i++;
        }
      }
        
      if($infants > 0) {
        foreach($travellers['I'] as $infant) {
          $params['PNR_AddMultiElements']['travellerInfo']['passengerData'][$i]['travellerInformation']['traveller']['surname'] = $infant['surname'];
          $params['PNR_AddMultiElements']['travellerInfo']['passengerData'][$i]['travellerInformation']['passenger']['firstName'] = $infant['first_name'];
          $params['PNR_AddMultiElements']['travellerInfo']['passengerData'][$i]['travellerInformation']['passenger']['type'] = 'INF';
          $i++;
        }
      }
        
      $segments[] = $onward;
      if(isset($return['itinerary'])) {
        $segments[] = $return;
      }
        
      $i = 0;
      foreach($segments as $segment) {
        $params['PNR_AddMultiElements']['originDestinationDetails'][$i]['originDestination']['origin'] = $segment['origin'];
        $params['PNR_AddMultiElements']['originDestinationDetails'][$i]['originDestination']['destination'] = $segment['destination'];
          
        $j = 0;
        foreach($segment['itinerary'] as $itinerary) {
          $params['PNR_AddMultiElements']['originDestinationDetails'][$i]['itineraryInfo'][$j]['elementManagementItinerary']['reference']['qualifier'] = 'SR';
          $params['PNR_AddMultiElements']['originDestinationDetails'][$i]['itineraryInfo'][$j]['elementManagementItinerary']['reference']['number'] = $j;
          $params['PNR_AddMultiElements']['originDestinationDetails'][$i]['itineraryInfo'][$j]['elementManagementItinerary']['segmentName'] = 'AIR';
          $params['PNR_AddMultiElements']['originDestinationDetails'][$i]['itineraryInfo'][$j]['elementManagementItinerary']['airAuxItinerary']['travelProduct']['product']['depDate'] = $itinerary['date'];
          $params['PNR_AddMultiElements']['originDestinationDetails'][$i]['itineraryInfo'][$j]['elementManagementItinerary']['airAuxItinerary']['travelProduct']['boardpointDetail']['cityCode'] = $itinerary['from'];
          $params['PNR_AddMultiElements']['originDestinationDetails'][$i]['itineraryInfo'][$j]['elementManagementItinerary']['airAuxItinerary']['travelProduct']['offpointDetail']['cityCode'] = $itinerary['to'];
          $params['PNR_AddMultiElements']['originDestinationDetails'][$i]['itineraryInfo'][$j]['elementManagementItinerary']['airAuxItinerary']['travelProduct']['company']['identification'] = $itinerary['company'];
          $params['PNR_AddMultiElements']['originDestinationDetails'][$i]['itineraryInfo'][$j]['elementManagementItinerary']['airAuxItinerary']['travelProduct']['productDetails']['identification'] = $itinerary['code'];
          $params['PNR_AddMultiElements']['originDestinationDetails'][$i]['itineraryInfo'][$j]['elementManagementItinerary']['airAuxItinerary']['travelProduct']['productDetails']['classOfService'] = $itinerary['class'];
          $params['PNR_AddMultiElements']['originDestinationDetails'][$i]['itineraryInfo'][$j]['elementManagementItinerary']['airAuxItinerary']['messageAction']['business']['function'] = 1;
          $params['PNR_AddMultiElements']['originDestinationDetails'][$i]['itineraryInfo'][$j]['elementManagementItinerary']['airAuxItinerary']['relatedProduct']['quantity']['function'] = 1;
          $params['PNR_AddMultiElements']['originDestinationDetails'][$i]['itineraryInfo'][$j]['elementManagementItinerary']['airAuxItinerary']['relatedProduct']['quantity']['status'] = 'NN';
          $params['PNR_AddMultiElements']['originDestinationDetails'][$i]['itineraryInfo'][$j]['elementManagementItinerary']['airAuxItinerary']['selectionDetailsAir']['selection']['option'] = 'P10';
          $j++;
        }
        $i++;
      }
      
      $this->_data = $this->_client->__soapCall('PNR_AddMultiElements', $params, NULL, new SoapHeader(AMD_HEAD_NAMESPACE, 'SessionId', $this->_headers['SessionId']), $this->_headers);
      debugDump($params, $this->_data);
    }
    
    /**
     * Security_SignOut 
     * Sign out from Amadeus
     */
    public function securitySignout() {
      $params = array();
      $params['Security_SignOut']['SessionId'] = $this->_headers['SessionId'];
  
      $this->_data = $this->_client->__soapCall('Security_SignOut', $params, NULL, new SoapHeader(AMD_HEAD_NAMESPACE, 'SessionId', $this->_headers['SessionId']), $this->_headers);
      debugDump($params, $this->_data);
    }
}
