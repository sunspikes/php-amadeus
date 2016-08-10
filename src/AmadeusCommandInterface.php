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
 * Interface AmadeusCommandInterface
 * 
 * @package Sunspikes\Amadeus
 */
interface AmadeusCommandInterface
{
    /**
     * Execute the API request
     *
     * @return void
     */
    public function execute();

    /**
     * Build the request parameters
     *
     * @return array
     */
    public function getParameters();

    /**
     * Get the API method name
     *
     * @return string
     */
    public function getName();
}
