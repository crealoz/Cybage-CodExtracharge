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

namespace Cybage\CodExtracharge\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Quote\Setup\QuoteSetupFactory;
use Magento\Sales\Setup\SalesSetupFactory;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;

/**
 * SalesModelServiceQuoteSubmitBefore
 *
 * @category  Class
 * @package   Cybage_CodExtracharge
 * @author    Cybage Software Pvt. Ltd. <Support_ecom@cybage.com>
 * @copyright 1995-2019 Cybage Software Pvt. Ltd., India
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @version   Release: 1.0.0
 * @link      http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 */
class InstallData implements InstallDataInterface
{
    /* protected $salesSetupFactory */
    protected $salesSetupFactory;

    /* protected $quoteSetupFactory */
    protected $quoteSetupFactory;
    private $eavSetupFactory;

    /**
     * Constructor
     *
     * @param SalesSetupFactory $salesSetupFactory
     * @param QuoteSetupFactory $quoteSetupFactory
     */
    public function __construct(
        SalesSetupFactory $salesSetupFactory,
        QuoteSetupFactory $quoteSetupFactory,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->salesSetupFactory = $salesSetupFactory;
        $this->quoteSetupFactory = $quoteSetupFactory;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * Create attributes
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface   $context
     */
    protected function _setupSalesTables(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $attributes = [
            'cyb_cod_amount' => 'Cash On Delivery Amount',
            'base_cyb_cod_amount' => 'Cash On Delivery Base Amount'
        ];

        $salesSetup = $this->salesSetupFactory->create(['setup' => $setup]);
        foreach ($attributes as $attributeCode => $attributeLabel) {
            $salesSetup->addAttribute('order', $attributeCode, ['type' => 'decimal']);
            $salesSetup->addAttribute('order_address', $attributeCode, ['type' => 'decimal']);
            $salesSetup->addAttribute('invoice', $attributeCode, ['type' => 'decimal']);
            $salesSetup->addAttribute('creditmemo', $attributeCode, ['type' => 'decimal']);
        }

        $quoteSetup = $this->quoteSetupFactory->create(['setup' => $setup]);
        foreach ($attributes as $attributeCode => $attributeLabel) {
            $quoteSetup->addAttribute('quote', $attributeCode, ['type' => 'decimal']);
            $quoteSetup->addAttribute('quote_address', $attributeCode, ['type' => 'decimal']);
        }
    }

    /**
     * Installs data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface   $context
     *
     * @return void
     */
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();
        $this->_setupSalesTables($setup, $context);
        $setup->endSetup();
    }
}
