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

namespace Cybage\CodExtracharge\Model\Sales\Pdf;

use Cybage\CodExtracharge\Helper\Data as cybCodData;
/**
 * Amount
 *
 * @category  Class
 * @package   Cybage_CodExtracharge
 * @author    Cybage <support_ecom@cybage.com>
 * @copyright 2017 cybage Pvt Ltd
 * @license   https://cybage.com Licence
 * @version   Release: 1.0.0
 * @link      http://cybage.com
 */
class Amount extends \Magento\Sales\Model\Order\Pdf\Total\DefaultTotal
{
  	public function __construct(
        \Magento\Tax\Helper\Data $taxHelper,
        \Magento\Tax\Model\Calculation $taxCalculation,
        \Magento\Tax\Model\ResourceModel\Sales\Order\Tax\CollectionFactory $ordersFactory,
        \Magento\Framework\Pricing\Helper\Data $priceHelper,
        \Cybage\CodExtracharge\Helper\Data $cybCodHelper,
             array $data = []
    ) {

        parent::__construct($taxHelper,$taxCalculation,$ordersFactory,$data);
        $this->_cybCodeHelper = $cybCodHelper;
        $this->_priceHelper = $priceHelper;
    }
    /**
     * Get Total amount from source
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->getOrder()->getCybCodAmount();
    }
    
    public function getTotalsForDisplay()
    {
        $amount = $this->_priceHelper->currency($this->getAmount(),true,false);
        $label = $this->_cybCodeHelper->getCybCodLabel() ?  $this->_cybCodeHelper->getCybCodLabel() : __($this->getTitle());
        $fontSize = $this->getFontSize() ? $this->getFontSize() : 7;
        $total = ['amount' => $amount, 'label' => ucwords(strtolower($label)), 'font_size' => $fontSize];
        return [$total];
    }
}
