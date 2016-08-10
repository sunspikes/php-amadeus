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

/**
 * Class SalesPeriodDetails
 *
 * Retrieve a sales report by date and can filter by airline code
 *
 * @package Sunspikes\Amadeus
 */
class SalesPeriodDetails extends AbstractAmadeusCommand
{
    private $startDate;
    private $endDate;
    private $airlineCode;

    /**
     * @param $startDate
     * @param $endDate
     * @param $airlineCode
     */
    public function __construct($startDate, $endDate, $airlineCode)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->airlineCode = $airlineCode;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        $start_date = explode('-', $this->startDate);
        $end_date = explode('-', $this->endDate);

        $params = array();
        $params['dateDetails']['businessSemantic'] = 'S';
        $params['salesPeriodDetails']['beginDateTime']['year'] = $start_date[0];
        $params['salesPeriodDetails']['beginDateTime']['month'] = $start_date[1];
        $params['salesPeriodDetails']['beginDateTime']['day'] = $start_date[2];
        $params['salesPeriodDetails']['endDateTime']['year'] = $end_date[0];
        $params['salesPeriodDetails']['endDateTime']['month'] = $end_date[1];
        $params['salesPeriodDetails']['endDateTime']['day'] = $end_date[2];

        if ($this->airlineCode !== null) {
            $params['validatingCarrierDetails']['companyIdentification']['marketingCompany'] = $this->airlineCode;
        }
        $params['requestOption']['selectionDetails']['option'] = 'SOF';

        return '$params';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'SalesReports_DisplayQueryReport';
    }
}
