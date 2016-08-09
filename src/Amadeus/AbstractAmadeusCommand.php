<?php

namespace Sunspikes\Amadeus;

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
