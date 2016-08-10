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
 * Class SecuritySignout
 *
 * Signs out from Amadeus
 *
 * @package Sunspikes\Amadeus
 */
class SecuritySignout extends AbstractAmadeusCommand
{
    public function getParameters()
    {
        $headers = $this->getAmadeusSoapClient()->getHeaders();
        $params['Security_SignOut']['SessionId'] = $headers['SessionId'];

        return $params;
    }

    public function getName()
    {
        return 'Security_SignOut';
    }
}
