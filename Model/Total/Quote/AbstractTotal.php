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

namespace Cybage\CodExtracharge\Model\Total\Quote;

use Magento\Quote\Api\PaymentMethodManagementInterface;
use Magento\Quote\Model\Quote\Address\Total\AbstractTotal as MageAbstractTotal;
use Magento\Quote\Model\Quote;

/**
 * AbstractTotal
 *
 * @category  class
 * @package   Cybage_CodExtracharge
 * @author    Cybage Software Pvt. Ltd. <Support_ecom@cybage.com>
 * @copyright 1995-2017 Cybage Software Pvt. Ltd., India
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @version   Release: 1.0.0
 * @link      http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 */
abstract class AbstractTotal extends MageAbstractTotal
{
    const CYB_PAYMENT_METHOD = 'cashondelivery';
    /**
     * @var PaymentMethodManagementInterface
     */
    private $paymentMethodManagement;

    /**
     * Constructor
     *
     * @param PaymentMethodManagementInterface $paymentMethodManagement
     */
    public function __construct(
        PaymentMethodManagementInterface $paymentMethodManagement
    ) {
        $this->paymentMethodManagement = $paymentMethodManagement;
    }

    /**
     * Return true if can apply totals
     *
     * @param Quote $quote
     *
     * @return bool
     */
    protected function _canApplyTotal(Quote $quote)
    {
        if (!$quote->getId()) {
            return false;
        }
        $paymentMethodsList = $this->paymentMethodManagement->getList($quote->getId());
        if ((count($paymentMethodsList) == 1) && ($paymentMethodsList[0]->getCode() == self::CYB_PAYMENT_METHOD)) {
            return true;
        }

        return ($quote->getPayment()->getMethod() == self::CYB_PAYMENT_METHOD);
    }
}
