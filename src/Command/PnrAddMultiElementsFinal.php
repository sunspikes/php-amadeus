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
 * Class PnrAddMultiElementsFinal
 *
 * Final booking save operation
 *
 * @package Sunspikes\Amadeus
 */
class PnrAddMultiElementsFinal extends AbstractAmadeusCommand
{
    /**
     * @return array
     */
    public function getParameters()
    {
        $params['PNR_AddMultiElements']['pnrActions']['optionCode'] = 11;

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
