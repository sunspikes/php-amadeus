<?php

namespace Sunspikes\Amadeus;

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
