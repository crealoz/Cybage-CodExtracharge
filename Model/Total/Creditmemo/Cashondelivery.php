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

namespace Cybage\CodExtracharge\Model\Total\Creditmemo;

use Magento\Sales\Model\Order\Creditmemo;
use Magento\Sales\Model\Order\Creditmemo\Total\AbstractTotal as MageAbstractTotal;
use Magento\Sales\Model\Order;

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
     * @param Creditmemo $creditmemo
     *
     * @return \Cybage\CodExtracharge\Model\Total\Creditmemo\Cashondelivery
     */
    public function collect(Creditmemo $creditmemo)
    {
        $order = $creditmemo->getOrder();
        $creditmemo->setCybCodAmount($order->getCybCodAmount());
        $creditmemo->setBaseCybCodAmount($order->getBaseCybCodAmount());

        if ($this->_canApplyTotal($order)) {
            $creditmemo->setGrandTotal($creditmemo->getGrandTotal() + $creditmemo->getCybCodAmount());
            $creditmemo->setBaseGrandTotal($creditmemo->getBaseGrandTotal() + $creditmemo->getBaseCybCodAmount());
        }
        return $this;
    }

    /**
     * check ca we apply to toatal
     *
     * @param Order $order
     *
     * @return type boolean
     */
    protected function _canApplyTotal(Order $order)
    {
        return ($order->getPayment()->getMethod() == self::CYB_PAYMENT_METHOD);
    }
}
