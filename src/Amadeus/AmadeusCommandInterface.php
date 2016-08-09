<?php

namespace Sunspikes\Amadeus;

interface AmadeusCommandInterface
{
    /**
     * @return void
     */
    public function execute();

    /**
     * @return array
     */
    public function getParameters();

    /**
     * @return string
     */
    public function getName();
}