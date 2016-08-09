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
    private $headers;

    public function __construct()
    {
        $this->headers = $this->getAmadeusSoapClient()->getHeaders();
    }

    public function getParameters()
    {
        $params['Security_SignOut']['SessionId'] = $this->headers['SessionId'];

        return $params;
    }

    public function getName()
    {
        return 'Security_SignOut';
    }
}