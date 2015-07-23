<?php
/**
 * Amadeus Sample client
 */

include 'src/Amadeus/Client.php';

use Sunspikes\Amadeus\Client;

// Instantiate the Amadeus class (Debug enabled)
$ws = new Client('AmadeusWebServices.wsdl', true);

// Authenticate
$ws->securityAuthenticate([YOUR_SOURCE], [YOUR_ORIGIN], [YOUR_PASSWORD], [PASSWORD_LENGTH], [ORGANIZATION_ID]);

// Travel from and to locations
$from = 'DEL';
$to = 'BLR';

// Travel Segments
$segments[] = array(
  'dep_date' => '230612',
  'dep_location' => 'DEL',
  'dest_location' => 'BLR',
  'company' => 'IT',
  'flight_no' => '201',
  'class' => 'Y',
  'passengers' => '2',
);
$segments[] = array(
  'dep_date' => '250612',
  'dep_location' => 'BLR',
  'dest_location' => 'DEL',
  'company' => 'IT',
  'flight_no' => '202',
  'class' => 'Y',
  'passengers' => '2',
);

// Setup travellers
$travellers['A'] = array(
  array(
    'surname' => 'DOE',
    'first_name' => 'JOHN'
  ),
);
$travellers['C'] = array(
  array(
    'surname' => 'DWYNE',
    'first_name' => 'JOHNSON'
  ),
);
$travellers['I'] = array(
  array(
    'first_name' => 'JANE'
  ),
);

// Airline Code
$code = 'IT';

// Here 2 types of passengers -> Adult and a Child
$types = 2;

// Make the booking
$ws->airSellFromRecommendation($from, $to, $segments);
$ws->pnrAddMultiElements($travellers);
$ws->farePricePNRWithBookingClass($code);
$ws->ticketCreateTSTFromPricing($types);
$ws->pnrAddMultiElementsFinal();

// To Retreive PNR pass the PNR ID returned by the previous booking call.
// $ws->pnrRetrieve('YFJG9V');

// Signout
$ws->securitySignout();
