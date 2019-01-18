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

namespace Cybage\CodExtracharge\Model\Config\Backend;

use Magento\Framework\App\Config\Value;
use Cybage\CodExtracharge\Api\CashondeliveryTableInterface;

class Csv extends Value
{
    /*
     * @var type Cybage\CodExtracharge\Api\CashondeliveryTableInterface
     */
    protected $cashondeliveryTableInterface;

    /**
     * Constructor
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $config
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param CashondeliveryTableInterface $cashondeliveryTableInterface
     * @param \Magento\Framework\App\Request\Http $httprequest
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $config,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        CashondeliveryTableInterface $cashondeliveryTableInterface,
        \Magento\Framework\App\Request\Http $httprequest,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
        $this->_httprequest = $httprequest;
        $this->cashondeliveryTableInterface = $cashondeliveryTableInterface;
    }

    /**
     * call after save
     * @return \Cybage\CodExtracharge\Model\Config\Backend\Csv
     */
   public function afterSave()
    {
        $uploadedFile  = $this->_httprequest->getFiles();
        if (empty($uploadedFile['groups']['cashondelivery']['fields']['cyb_import']['value']['tmp_name'])) {
            return $this;
        }
        $csvFile = $uploadedFile['groups']['cashondelivery']['fields']['cyb_import']['value']['tmp_name'];
        $this->cashondeliveryTableInterface->saveFromFile($csvFile);
        return parent::afterSave();
    }
}
