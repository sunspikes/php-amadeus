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

use Sunspikes\Amadeus\AmadeusClientException;
use Sunspikes\Amadeus\AmadeusCommandInterface;
use Sunspikes\Amadeus\AmadeusSoapClient;

/**
 * Class AbstractAmadeusCommand
 * 
 * @package Sunspikes\Amadeus\Command
 */
abstract class AbstractAmadeusCommand implements AmadeusCommandInterface
{
    /** @var AmadeusSoapClient */
    private $amadeusSoapClient;

    /**
     * @param AmadeusSoapClient $amadeusSoapClient
     */
    public function setAmadeusSoapClient(AmadeusSoapClient $amadeusSoapClient)
    {
        $this->amadeusSoapClient = $amadeusSoapClient;
    }

    /**
     * @return AmadeusSoapClient
     */
    public function getAmadeusSoapClient()
    {
        return $this->amadeusSoapClient;
    }

    /**
     * @throws AmadeusClientException
     */
    public function execute()
    {
        if (null === $this->amadeusSoapClient) {
            throw new AmadeusClientException("Error: Set the AmadeusSoapClient");
        }

        $this->amadeusSoapClient->execute(
            $this->getName(),
            $this->getParameters()
        );
    }
}
