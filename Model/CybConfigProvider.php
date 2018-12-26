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

namespace Cybage\CodExtracharge\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Cybage\CodExtracharge\Helper\Data as cybCodData;

/**
 * CashondeliveryCart
 *
 * @category  Class
 * @package   Cybage_CodExtracharge
 * @author    Cybage Software Pvt. Ltd. <Support_ecom@cybage.com>
 * @copyright 1995-2017 Cybage Software Pvt. Ltd., India
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @version   Release: 1.0.0
 * @link      http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 */

class CybConfigProvider implements ConfigProviderInterface
{

    /**
     * Constructor
     *
     * @param cybCodData $cybCodHelper
     */
    const CYB_PAYMENT_METHOD = 'cashondelivery';
    public function __construct(
        cybCodData $cybCodHelper
    ) {
        $this->_cybCodeHelper = $cybCodHelper;
    }

    /**
     * Set config value for checkout
     *
     * @return type array
     */
    public function getConfig()
    {
        $config = [];
        $config['cybcodlabel'] = $this->_cybCodeHelper->getCybCodLabel();
        $config['cybPaymentMethod'] = self::CYB_PAYMENT_METHOD;
        $config['cybCodInfo'] = "/carts/mine/cyb-cashondelivery-information";
        return $config;
    }
}
