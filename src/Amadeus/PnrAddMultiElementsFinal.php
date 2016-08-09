<?php

namespace Sunspikes\Amadeus;

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
