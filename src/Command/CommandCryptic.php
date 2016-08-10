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
 * Class CommandCryptic
 *
 * @package Sunspikes\Amadeus
 */
class CommandCryptic extends AbstractAmadeusCommand
{
   private $string;

    public function __construct($string)
    {
        $this->string = $string;
    }

    public function getParameters()
    {
        $params['Command_Cryptic']['longTextString']['textStringDetails'] = $this->string;
        $params['Command_Cryptic']['messageAction']['messageFunctionDetails']['messageFunction'] = 'M';

        return $params;
    }

    public function getName()
    {
        return 'Command_Cryptic';
    }
}
