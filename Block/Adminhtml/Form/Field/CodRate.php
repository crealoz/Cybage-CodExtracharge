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

class CodRate extends \Magento\Framework\View\Element\Html\Select
{

    /**
     * @var \Magento\Customer\Model\GroupFactory $groupfactory
     */
    protected $groupfactory;

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Context $context
     * @param \Magento\Braintree\Model\System\Config\Source\Country $countrySource
     * @param \Magento\Directory\Model\ResourceModel\Country\CollectionFactory $countryCollectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Magento\Customer\Model\GroupFactory $groupfactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->groupfactory = $groupfactory;
    }

    /**
     *
     * @return type
     */
    public function _toHtml()
    {
        if (!$this->getOptions()) {
            $customerGroupCollection = $this->groupfactory->create()->getCollection();
            foreach ($customerGroupCollection as $customerGroup) {
                     $this->addOption($customerGroup->getCustomerGroupId(), $customerGroup->getCustomerGroupCode());
            }
        }
        return parent::_toHtml();
    }

    /**
     * Sets name for input element
     *
     * @param string $value
     * @return $this
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }
}
