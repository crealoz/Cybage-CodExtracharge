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

namespace Cybage\CodExtracharge\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Cashondelivery
 *
 * @category  Helper
 * @package   Cybage_CodExtracharge
 * @author    Cybage Software Pvt. Ltd. <Support_ecom@cybage.com>
 * @copyright 1995-2017 Cybage Software Pvt. Ltd., India
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @version   Release: 1.0.0
 * @link      http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 */

class Data extends AbstractHelper
{
    /* @const COD extra amount*/
    const XML_COD_AMT = 'payment/cashondelivery/cyb_cod_amount';

    /* @const COD label*/
    const XML_COD_LABEL = 'payment/cashondelivery/cyb_cod_label';

    /**
     * Constructor
     *
     * @param ScopeConfigInterface $scopeConfigInterface
     */
    public function __construct(
        ScopeConfigInterface $scopeConfigInterface
    ) {
        $this->scopeConfigInterface = $scopeConfigInterface;
    }

    /**
     * Get Cod extra charge amount
     *
     * @return type float
     */
    public function getCybCodAmount()
    {
        return $this->scopeConfigInterface->getValue(
            self::XML_COD_AMT,
            ScopeInterface::SCOPE_WEBSITE
        );
    }

    /**
     * Get label for cod extra charge
     *
     * @return type
     */
    public function getCybCodLabel()
    {
        return $this->scopeConfigInterface->getValue(
            self::XML_COD_LABEL,
            ScopeInterface::SCOPE_WEBSITE
        );
    }
}
