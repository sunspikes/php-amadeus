<?php

namespace Sunspikes\Amadeus;

/**
 * Class TicketCreateTstFromPricing
 * 
 * @package Sunspikes\Amadeus
 */
class TicketCreateTstFromPricing extends AbstractAmadeusCommand
{
    private $types;

    /**
     * @param $types
     */
    public function __construct($types)
    {
        $this->types = $types;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        for ($i = 0; $i < $this->types; $i++) {
            $params['Ticket_CreateTSTFromPricing']['psaList'][$i]['itemReference']['referenceType'] = 'TST';
            $params['Ticket_CreateTSTFromPricing']['psaList'][$i]['itemReference']['uniqueReference'] = $i + 1;
        }

        return $params;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Ticket_CreateTSTFromPricing';
    }
}
