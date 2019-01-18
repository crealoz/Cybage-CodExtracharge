<?php
/**
 * Cybage CodExtracharge
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * It is available on the World Wide Web at:
 * http://opensource.org/licenses/osl-3.0.php
 * If you are unable to access it on the World Wide Web, please send an email
 * To: Support_ecom@cybage.com.  We will send you a copy of the source file.
 *
 * @category  Apply_Extra_Charge_On_COD_Payment_Method
 * @package   Cybage_CodExtracharge
 * @author    Cybage Software Pvt. Ltd. <Support_ecom@cybage.com>
 * @copyright 1995-2019 Cybage Software Pvt. Ltd., India
 *            http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Cybage\CodExtracharge\Api;

/**
 * Interface CartInterface
 * @package MSP\CashOnDelivery\Api\Data
 * @api
 */
interface CashondeliveryTableInterface
{
    /**
     * Get cash on delivery fee
     *
     * @param double $amount
     * @param string $country
     * @param string $region
     * @return double
     */
    public function getCodCharge($amount, $country);

    /**
     * Get table as array
     *
     * @return array
     */
    public function getTableAsArray();

    /**
     * Get table as CSV
     *
     * @return string
     */
    public function getTableAsCsv();

    /**
     * Save from file
     *
     * @param string $fileName
     * @return int
     */
    public function saveFromFile($fileName);

    /**
     * Get number of rows
     * @return int
     */
    public function getRowsCount();
}
