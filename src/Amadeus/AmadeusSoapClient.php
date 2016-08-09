<?php

namespace Sunspikes\Amadeus;

class AmadeusSoapClient
{
    /**
     * The main Amadeus WS namespace
     *
     * @var string
     */
    const AMD_HEAD_NAMESPACE = 'http://webservices.amadeus.com/definitions';
    /**
     * Response data
     */
    private $data;
    /**
     * Response headers
     */
    private $headers;
    /**
     * Hold the client object
     */
    private $client;
    /**
     * Indicates debug mode on/off
     */
    private $debug;

    /**
     * @param $wsdl  string   Path to the WSDL file
     * @param $debug boolean  Enable/disable debug mode
     */
    public function __construct($wsdl, $debug = false)
    {
        $this->debug = $debug;
        $this->client = new \SoapClient($wsdl, array('trace' => $debug));
    }

    /**
     * @param $method
     * @param $params
     */
    public function execute($method, $params)
    {
        $this->data = $this->client->__soapCall(
            $method,
            $params,
            null,
            new \SoapHeader(Client::AMD_HEAD_NAMESPACE, 'SessionId', null),
            $this->headers
        );

        if ($this->debug) $this->debugDump($method, $params);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param $method
     * @param $params
     */
    private function debugDump($method, $params)
    {
        /** @noinspection ForgottenDebugOutputInspection */
        print_r([
            'method' => $method,
            'params' => $params,
            'data' => $this->data,
            'request' => $this->client->__getLastRequest(),
            'response' => $this->client->__getLastResponse(),
        ]);
    }
}