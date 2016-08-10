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
 * Class PnrRetrieve
 *
 * Get PNR by ID
 *
 * @package Sunspikes\Amadeus
 */
class PnrRetrieve extends AbstractAmadeusCommand
{
    private $pnrId;

    /**
     * @param $pnrId
     */
    public function __construct($pnrId)
    {
        $this->pnrId = $pnrId;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        $params['PNR_Retrieve']['retrievalFacts']['retrieve']['type'] = 2;
        $params['PNR_Retrieve']['retrievalFacts']['reservationOrProfileIdentifier']['reservation']['controlNumber'] = $this->pnrId;

        return $params;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'PNR_Retrieve';
    }
}
