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

namespace Cybage\CodExtracharge\Block\Adminhtml\System\Config;

use Cybage\CodExtracharge\Api\CashondeliveryTableInterface;
use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;

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
class Rulesdata extends Template
{

    /**
     * Construct
     * @param Context $context
     * @param CashondeliveryTableInterface $cashondeliveryTableInterface
     * @param array $data
     */
    public function __construct(
        Context $context,
        CashondeliveryTableInterface $cashondeliveryTableInterface,
        array $data = []
    ) {
        $this->cashondeliveryTableInterface = $cashondeliveryTableInterface;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getRulesJson()
    {
        return json_encode([
            'html' => $this->getContent()
        ]);
    }

    /**
     * Create html to show configured rules
     * @return string
     */
    public function getContent()
    {
        $columns = $this->cashondeliveryTableInterface->_columns;
        $rulesData = $this->cashondeliveryTableInterface->getTableAsArray();
        $html = "<table class='data-grid'> ";
        $html .= "<tr>";
        foreach ($columns as $column) {
            $html .= "<th>".$column."</th>";
        }
        $html .= "</tr>";
        foreach ($rulesData as $rules) {
            $html .= "<tr>";
            foreach ($columns as $column) {
                $html .= "<td>".$rules[$column]."</td>";
            }
            $html .= "</tr>";
        }
        $html .= "</table>";
        return $html;
    }
}
