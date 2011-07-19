<?php
/**
 * Sample client
 */
 
require_once('Amadeus.class.php');

$ws = new Amadeus('AmadeusWebServices.wsdl', true);
$ws->securityAuthenticate('AAAAAAA', 'AAAAAA', 'AAAAAAA', 12);

$travelData[0]['from'] = 'BLR';
$travelData[0]['to'] = 'MAA';
$travelData[0]['segments'][] = array('dep_date' => '021111', 'dep_location' => 'BLR', 'dest_location' => 'MAA',  'company' => 'IC', 'flight_no' => '509', 'class' => 'W', 'passengers' => '1');

$travellers['A'] = array( array('surname' => 'JOHNSON', 'first_name' => 'DWYNE') );
$travellers['C'] = array();
$travellers['I'] = array();

$book_data['full_name'] = 'DWYNE JOHNSON';
$book_data['address'] = 'MR DWYNE JOHNSON, BUCKINGHAM PALACE, LONDON, N1 1BP, UK';
$book_data['telephone'] = '012 6266262';

$types = 1;

$data = $ws->_air_SellFromRecommendation($travelData);
print "Air_SellFromRecommendation<br />";
print_r($ws->client->__getLastRequest());
print_r($ws->client->__getLastResponse());

$data2 = $ws->pnrAddMultiElements($travellers, $book_data);
print "PNR_AddMultiElements<br />";
print_r($ws->client->__getLastRequest());
print_r($ws->client->__getLastResponse());

$data3 = $ws->_fare_PricePNRWithBookingClass();
print "Fare_PricePNRWithBookingClass<br />";
print_r($ws->client->__getLastRequest());
print_r($ws->client->__getLastResponse());

$data4 = $ws->_ticket_CreateTSTFromPricing($types);
print "Ticket_CreateTSTFromPricing<br />";
print_r($ws->client->__getLastRequest());
print_r($ws->client->__getLastResponse());

$data5 = $ws->_pnrAddMultiElements_save();
print "PNR_AddMultiElements<br />";
print_r($ws->client->__getLastRequest());
print_r($ws->client->__getLastResponse());

$ws->securitySignout();