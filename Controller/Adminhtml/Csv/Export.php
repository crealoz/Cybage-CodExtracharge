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

namespace Cybage\CodExtracharge\Controller\Adminhtml\Csv;

use Magento\Backend\App\Action;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\ResponseInterface;
use Magento\Backend\App\Response\Http\FileFactory;
use Cybage\CodExtracharge\Api\CashondeliveryTableInterface;

class Export extends Action
{
    /* @var type Cybage\CodExtracharge\Api\CashondeliveryTableInterface */
    protected $cashondeliveryTableInterface;

    /* @var type Magento\Backend\App\Response\Http\FileFactory */
    protected $fileFactory;

    /**
     * Construct
     * @param \Magento\Backend\App\Action\Context $context
     * @param CashondeliveryTableInterface $cashondeliveryTableInterface
     * @param FileFactory $fileFactory
     */
    public function __construct(
        Action\Context $context,
        CashondeliveryTableInterface $cashondeliveryTableInterface,
        FileFactory $fileFactory
    ) {
        parent::__construct($context);
        $this->cashondeliveryTableInterface = $cashondeliveryTableInterface;
        $this->fileFactory = $fileFactory;
    }

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $csvFile = $this->cashondeliveryTableInterface->getTableAsCsv();
        return $this->fileFactory->create(
            'cyb_codextracharge.csv',
            $csvFile,
            DirectoryList::VAR_DIR,
            'text/csv',
            null
        );
    }

    /**
     * 
     * @return type boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magento_Payment::payment');
    }
}
