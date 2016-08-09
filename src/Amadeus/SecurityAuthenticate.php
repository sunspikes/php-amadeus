<?php

namespace Sunspikes\Amadeus;

/**
 * Class SecurityAuthenticate
 *
 * Autheticates with Amadeus
 *
 * @package Sunspikes\Amadeus
 */
class SecurityAuthenticate extends AbstractAmadeusCommand
{
    private $source;
    private $origin;
    private $password;
    private $passlen;
    private $org;

    /**
     * @param string  $source   sourceOffice string
     * @param string  $origin   originator string
     * @param string  $password password binaryData
     * @param integer $passlen  length of binaryData
     * @param string  $org      organizationId string
     */
    public function __construct($source, $origin, $password, $passlen, $org)
    {
        $this->source = $source;
        $this->origin = $origin;
        $this->password = $password;
        $this->passlen = $passlen;
        $this->org = $org;
    }

    public function getParameters()
    {
        $params['Security_Authenticate']['userIdentifier']['originIdentification']['sourceOffice'] = $this->source;
        $params['Security_Authenticate']['userIdentifier']['originatorTypeCode'] = 'U';
        $params['Security_Authenticate']['userIdentifier']['originator'] = $this->origin;
        $params['Security_Authenticate']['dutyCode']['dutyCodeDetails']['referenceQualifier'] = 'DUT';
        $params['Security_Authenticate']['dutyCode']['dutyCodeDetails']['referenceIdentifier'] = 'SU';
        $params['Security_Authenticate']['systemDetails']['organizationDetails']['organizationId'] = $this->org;
        $params['Security_Authenticate']['passwordInfo']['dataLength'] = $this->passlen;
        $params['Security_Authenticate']['passwordInfo']['dataType'] = 'E';
        $params['Security_Authenticate']['passwordInfo']['binaryData'] = $this->password;

        return $params;
    }

    public function getName()
    {
        return 'Security_Authenticate';
    }
}