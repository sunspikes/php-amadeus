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
        $params = [];
        
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
