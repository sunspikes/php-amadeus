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
 * @see https://extranets.us.amadeus.com
 */
class Client
{
    private $client;

    /**
     * @param $wsdl  string   Path to the WSDL file
     * @param $debug boolean  Enable/disable debug mode
     */
    public function __construct($wsdl, $debug = false)
    {
        $this->client = new AmadeusSoapClient($wsdl, array('trace' => $debug));
    }

    public function __call($name, $arguments)
    {
        $name = __NAMESPACE__ .'\\'. ucfirst($name);

        if (! class_exists($name)) {
            throw new AmadeusClientException("Error: $name not implemented");
        }

        $class = new \ReflectionClass($name);
        $object = $class->newInstanceArgs($arguments);
        $object->setAmadeusSoapClient($this->client);
        call_user_func([$object, 'execute']);
    }
}
