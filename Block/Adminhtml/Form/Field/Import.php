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
namespace Cybage\CodExtracharge\Block\Adminhtml\Form\Field;

use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Escaper;
use Magento\Framework\Data\Form\Element\Factory;
use Magento\Framework\Data\Form\Element\CollectionFactory;
use Cybage\CodExtracharge\Api\CashondeliveryTableInterface;

class Import extends AbstractElement
{
    /**
     *
     * @var type Cybage\CodExtracharge\Api\CashondeliveryTableInterface
     */
    protected $cashondeliveryTableInterface;

    /**
     * Constructor
     * @param Factory $factoryElement
     * @param CollectionFactory $factoryCollection
     * @param Escaper $escaper
     * @param CashondeliveryTableInterface $cashondeliveryTableInterface
     * @param array $data
     */
    public function __construct(
        Factory $factoryElement,
        CollectionFactory $factoryCollection,
        Escaper $escaper,
        CashondeliveryTableInterface $cashondeliveryTableInterface,
        array $data = []
    ) {
        parent::__construct($factoryElement, $factoryCollection, $escaper, $data);

        $this->cashondeliveryTableInterface = $cashondeliveryTableInterface;
    }

    /**
     * Construct
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setType('file');
    }

    /**
     * Create html
     * @return string
     */
    public function getElementHtml()
    {
        $res = parent::getElementHtml();
        $rowsCount = $this->cashondeliveryTableInterface->getRowsCount();

        if ($rowsCount) {
            $res .= '<br /><p class="note">' . __('You have <a href="#" class="rules module-version popup" id="custom-rules"><strong>%1</strong> rule(s)</a> configured', [$rowsCount]) . '</p>';
        } else {
            $res .= '<br /><p class="note">' . __('Rules table is empty') . '</p>';
        }

        return $res;
    }
}
