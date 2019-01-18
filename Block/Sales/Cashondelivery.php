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

namespace Cybage\CodExtracharge\Block\Sales;

use Magento\Framework\View\Element\Template;
use Magento\Framework\DataObject;
use Magento\Sales\Api\Data\InvoiceInterface;
use Magento\Sales\Api\Data\CreditmemoInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Cybage\CodExtracharge\Helper\Data as cybCodData;
use Cybage\CodExtracharge\Model\Payment;

/**
 * Cashondelivery
 *
 * @category  Class
 * @package   Cybage_CodExtracharge
 * @author    Cybage Software Pvt. Ltd. <Support_ecom@cybage.com>
 * @copyright 1995-2019 Cybage Software Pvt. Ltd., India
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @version   Release: 1.0.0
 * @link      http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 */
class Cashondelivery extends Template
{
    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param cybCodData                                       $cybCodHelper
     * @param array                                            $data
     */
    public function __construct(
        Template\Context $context,
        cybCodData $cybCodHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_cybCodeHelper = $cybCodHelper;
    }

    /**
     * Display Summary
     *
     * @return boolean
     */
    public function displayFullSummary()
    {
        return true;
    }

    /**
     * Initialise totals
     *
     * @return \Cybage\CodExtracharge\Block\Sales\Cashondelivery
     */
    public function initTotals()
    {
        $parent = $this->getParentBlock();
        $source = $parent->getSource();

        $payment = $this->getPayment($source);
        if ($payment && ($payment->getMethod() == Payment::CODE)) {
            $fee = new DataObject(
                [
                    'code' => 'cyb_codextracharge',
                    'strong' => false,
                    'value' => $source->getBaseCybCodAmount(),
                    'label' => $this->_cybCodeHelper->getCybCodLabel()
                ]
            );
            $parent->addTotalBefore($fee, 'grand_total');
        }
        return $this;
    }

    /**
     * Get payment
     *
     * @param type $source
     *
     * @return type
     */
    protected function getPayment($source)
    {
        if ($source instanceof InvoiceInterface) {
            return $source->getOrder()->getPayment();
        }

        if ($source instanceof OrderInterface) {
            return $source->getPayment();
        }

        if ($source instanceof CreditMemoInterface) {
            return $source->getOrder()->getPayment();
        }
        return null;
    }
}
