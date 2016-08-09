<?php

namespace Sunspikes\Amadeus;

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
