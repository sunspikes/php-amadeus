<?php
/*
 * Amadeus Flight Booking and Search & Booking API Client
 *
 * (c) Krishnaprasad MG <sunspikes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sunspikes\Amadeus;

/**
 * Class Client
 *
 * @see https://extranets.us.amadeus.com
 *
 * @package Sunspikes\Amadeus
 */
class Client
{
    private $client;

    /**
     * @param string $wsdl    Path to the WSDL file
     * @param boolean $debug  Enable/disable debug mode
     */
    public function __construct($wsdl, $debug = false)
    {
        $this->client = new AmadeusSoapClient($wsdl, $debug);
    }

    /**
     * @param $name
     * @param $arguments
     * @throws AmadeusClientException
     */
    public function __call($name, $arguments)
    {
        $name = __NAMESPACE__ .'\\Command\\'. ucfirst($name);

        if (! class_exists($name)) {
            throw new AmadeusClientException("Error: $name not implemented");
        }

        $class = new \ReflectionClass($name);
        $object = $class->newInstanceArgs($arguments);
        $object->setAmadeusSoapClient($this->client);
        call_user_func([$object, 'execute']);
    }
}
