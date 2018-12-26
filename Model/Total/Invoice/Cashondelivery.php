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
 * @copyright 1995-2017 Cybage Software Pvt. Ltd., India
 *            http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Cybage\CodExtracharge\Model\Total\Invoice;

use Magento\Sales\Model\Order\Invoice;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\Invoice\Total\AbstractTotal as MageAbstractTotal;

/**
 * Cashondelivery
 *
 * @category  class
 * @package   Cybage_CodExtracharge
 * @author    Cybage Software Pvt. Ltd. <Support_ecom@cybage.com>
 * @copyright 1995-2017 Cybage Software Pvt. Ltd., India
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @version   Release: 1.0.0
 * @link      http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 */

class Cashondelivery extends MageAbstractTotal
{
    const CYB_PAYMENT_METHOD = 'cashondelivery';
    /**
     * Collect
     *
     * @param Invoice $invoice
     *
     * @return \Cybage\CodExtracharge\Model\Total\Invoice\Cashondelivery
     */
    public function collect(Invoice $invoice)
    {
        $order = $invoice->getOrder();
        $invoice->setCybCodAmount($order->getCybCodAmount());
        $invoice->setBaseCybCodAmount($order->getBaseCybCodAmount());

        if ($this->_canApplyTotal($order)) {
            $invoice->setGrandTotal($invoice->getGrandTotal() + $invoice->getCybCodAmount());
            $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() + $invoice->getBaseCybCodAmount());
        }
        return $this;
    }

    /**
     * Return true if can apply totals
     *
     * @param Order $order
     *
     * @return bool
     */
    protected function _canApplyTotal(Order $order)
    {
        return ($order->getPayment()->getMethod() == self::CYB_PAYMENT_METHOD);
    }
}
