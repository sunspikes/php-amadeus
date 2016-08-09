<?php

namespace Sunspikes\Amadeus;

/**
 * Class PnrAddMultiElements
 *
 * Make reservation call
 *
 * @package Sunspikes\Amadeus
 */
class PnrAddMultiElements extends AbstractAmadeusCommand
{
    private $travellers;
    private $address;
    private $phone;

    /**
     * @param $travellers
     * @param $address
     * @param $phone
     */
    public function __construct($travellers, $address, $phone)
    {
        $this->travellers = $travellers;
        $this->address = $address;
        $this->phone = $phone;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        $adult = count($this->travellers['A']);
        $children = count($this->travellers['C']);
        $infants = count($this->travellers['I']);
        $params = array();
        $params['PNR_AddMultiElements']['pnrActions']['optionCode'] = 0;

        $i = 0;
        $inf = 0;
        foreach ($this->travellers['A'] as $adult) {
            $trav = 0;
            $params['PNR_AddMultiElements']['travellerInfo'][$i]['elementManagementPassenger']['reference']['qualifier']
                = 'PR';
            $params['PNR_AddMultiElements']['travellerInfo'][$i]['elementManagementPassenger']['reference']['number']
                = $i + 1;
            $params['PNR_AddMultiElements']['travellerInfo'][$i]['elementManagementPassenger']['segmentName'] = 'NM';

            $params['PNR_AddMultiElements']['travellerInfo'][$i]['passengerData']['travellerInformation']['traveller']['surname']
                = $adult['surname'];
            $params['PNR_AddMultiElements']['travellerInfo'][$i]['passengerData']['travellerInformation']['traveller']['quantity']
                = 1;
            $params['PNR_AddMultiElements']['travellerInfo'][$i]['passengerData']['travellerInformation']['passenger'][$trav]['firstName']
                = $adult['first_name'];
            $params['PNR_AddMultiElements']['travellerInfo'][$i]['passengerData']['travellerInformation']['passenger'][$trav]['type']
                = 'ADT';

            if ($infants > 0) {
                $params['PNR_AddMultiElements']['travellerInfo'][$i]['passengerData']['travellerInformation']['passenger'][$trav]['infantIndicator']
                    = 2;
                $trav++;
                $params['PNR_AddMultiElements']['travellerInfo'][$i]['passengerData']['travellerInformation']['passenger'][$trav]['firstName']
                    = $this->travellers['I'][$inf]['first_name'];
                $params['PNR_AddMultiElements']['travellerInfo'][$i]['passengerData']['travellerInformation']['passenger'][$trav]['type']
                    = 'INF';
                $infants--;
                $inf++;
            }
            $i++;
        }

        if ($children > 0) {
            foreach ($this->travellers['C'] as $child) {
                $trav = 0;
                $params['PNR_AddMultiElements']['travellerInfo'][$i]['elementManagementPassenger']['reference']['qualifier']
                    = 'PR';
                $params['PNR_AddMultiElements']['travellerInfo'][$i]['elementManagementPassenger']['reference']['number']
                    = $i + 1;
                $params['PNR_AddMultiElements']['travellerInfo'][$i]['elementManagementPassenger']['segmentName'] = 'NM';

                $params['PNR_AddMultiElements']['travellerInfo'][$i]['passengerData']['travellerInformation']['traveller']['surname']
                    = $child['surname'];
                $params['PNR_AddMultiElements']['travellerInfo'][$i]['passengerData']['travellerInformation']['traveller']['quantity']
                    = 1;
                $params['PNR_AddMultiElements']['travellerInfo'][$i]['passengerData']['travellerInformation']['passenger'][$trav]['firstName']
                    = $child['first_name'];
                $params['PNR_AddMultiElements']['travellerInfo'][$i]['passengerData']['travellerInformation']['passenger'][$trav]['type']
                    = 'CHD';

                $i++;
            }
        }

        $j = 0;
        $params['PNR_AddMultiElements']['dataElementsMaster']['marker1'] = null;
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['elementManagementData']['reference']['qualifier']
            = 'OT';
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['elementManagementData']['reference']['number']
            = 1;
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['elementManagementData']['segmentName']
            = 'RF';
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['freetextData']['freetextDetail']['subjectQualifier']
            = 3;
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['freetextData']['freetextDetail']['type']
            = 'P22';
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['freetextData']['longFreetext']
            = 'Received From Whoever';

        $j++;
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['elementManagementData']['reference']['qualifier']
            = 'OT';
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['elementManagementData']['reference']['number']
            = 2;
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['elementManagementData']['segmentName']
            = 'TK';
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['ticketElement']['ticket']['indicator']
            = 'OK';

        $j++;
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['elementManagementData']['reference']['qualifier']
            = 'OT';
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['elementManagementData']['reference']['number']
            = 3;
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['elementManagementData']['segmentName']
            = 'ABU';
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['freetextData']['freetextDetail']['subjectQualifier']
            = 3;
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['freetextData']['freetextDetail']['type']
            = 2;
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['freetextData']['longFreetext']
            = $this->address;

        $j++;
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['elementManagementData']['reference']['qualifier']
            = 'OT';
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['elementManagementData']['reference']['number']
            = 4;
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['elementManagementData']['segmentName']
            = 'AP';
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['freetextData']['freetextDetail']['subjectQualifier']
            = 3;
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['freetextData']['freetextDetail']['type']
            = 5;
        $params['PNR_AddMultiElements']['dataElementsMaster']['dataElementsIndiv'][$j]['freetextData']['longFreetext']
            = $this->phone;

        return $params;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'PNR_AddMultiElements';
    }
}
