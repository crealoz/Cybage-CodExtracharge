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

namespace Cybage\CodExtracharge\Model\Total\Quote;

use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Quote\Api\PaymentMethodManagementInterface;
use Magento\Quote\Model\Quote\Address\Total;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote;
use Cybage\CodExtracharge\Helper\Data;
use Magento\Quote\Model\Quote\Address;
use Cybage\CodExtracharge\Api\CashondeliveryInterface;

/**
 * Cashondelivery
 *
 * @category  class
 * @package   Cybage_CodExtracharge
 * @author    Cybage Software Pvt. Ltd. <Support_ecom@cybage.com>
 * @copyright 1995-2019 Cybage Software Pvt. Ltd., India
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @version   Release: 1.0.0
 * @link      http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 */
class Cashondelivery extends AbstractTotal
{

    /* @var type Magento\Framework\Pricing\PriceCurrencyInterface */
    protected $_priceCurrencyInterface;

    /* @var type Cybage\CodExtracharge\Api\CashondeliveryInterface */
    protected $_cashOnDeliveryInterface;
    

    /**
     * Constructor
     * @param PaymentMethodManagementInterface $paymentMethodManagement
     * @param PriceCurrencyInterface $priceCurrencyInterface
     * @param CashondeliveryInterface $cashOnDeliveryInterface
     * @param Data $cybCodHelper
     */
    public function __construct(
        PaymentMethodManagementInterface $paymentMethodManagement,
        PriceCurrencyInterface $priceCurrencyInterface,
        CashondeliveryInterface $cashOnDeliveryInterface,
        Data $cybCodHelper
    ) {
        parent::__construct($paymentMethodManagement);
        $this->_cashOnDeliveryInterface = $cashOnDeliveryInterface;
        $this->_priceCurrencyInterface = $priceCurrencyInterface;
        $this->_cybCodeHelper = $cybCodHelper;
        $this->setCode('cyb_codextracharge');
    }

    /**
     * Collect
     *
     * @param Quote                       $quote
     * @param ShippingAssignmentInterface $shippingAssignment
     * @param Total                       $total
     *
     * @return \Cybage\CodExtracharge\Model\Total\Quote\Cashondelivery
     */
    public function collect(
        Quote $quote,
        ShippingAssignmentInterface $shippingAssignment,
        Total $total
    ) {
        if ($shippingAssignment->getShipping()->getAddress()->getAddressType() != Address::TYPE_SHIPPING
            || $quote->isVirtual()
        ) {
            return $this;
        }

        $country = $quote->getShippingAddress()->getCountryModel()->getData('iso2_code');
        $baseAmount = $this->_cashOnDeliveryInterface->getBaseAmount($total->getAllBaseTotalAmounts(), $country);
        $amount = $this->_priceCurrencyInterface->convert($baseAmount);

        if ($this->_canApplyTotal($quote)) {
            $total->setBaseTotalAmount('cyb_codextracharge', $baseAmount);
            $total->setTotalAmount('cyb_codextracharge', $amount);

            $total->setBaseCybCodAmount($baseAmount);
            $total->setCybCodAmount($amount);

            $total->setBaseGrandTotal($total->getBaseGrandTotal() + $baseAmount);
            $total->setGrandTotal($total->getGrandTotal() + $amount);
        }

        $quote->setBaseCybCodAmount($baseAmount);
        $quote->setCybCodAmount($amount);

        return $this;
    }

    /**
     * Get new data in total
     *
     * @param Quote $quote
     * @param Total $total
     *
     * @return type array
     */
    public function fetch(Quote $quote, Total $total)
    {
        if ($this->_canApplyTotal($quote)) {
            return [
                'code' => $this->getCode(),
                'title' => $this->_cybCodeHelper->getCybCodLabel(),
                'value' => $total->getCybCodAmount(),
            ];
        }

        return null;
    }

    /**
     * Get label
     *
     * @return type
     */
    public function getLabel()
    {
        return __('Cash On Delivery');
    }
}
