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

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * SetupTable
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    protected function _setupTable(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $tableName = $setup->getTable('cyb_codextracharge');

        $table = $setup->getConnection()
            ->newTable($tableName)
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Entity ID'
            )
            ->addColumn(
                'website',
                Table::TYPE_TEXT,
                255,
                [],
                'Website ID'
            )
            ->addColumn(
                'country',
                Table::TYPE_TEXT,
                255,
                [],
                'Country'
            )
            ->addColumn(
                'amount_above',
                Table::TYPE_DECIMAL,
                '10,4',
                [],
                'Amount on which this charge needs to apply'
            )
            ->addColumn(
                'amount_max',
                Table::TYPE_DECIMAL,
                '10,4',
                [],
                'Amount on which this charge should not apply'
            )
            ->addColumn(
                'cod_charge',
                Table::TYPE_DECIMAL,
                '10,4',
                [],
                'COD charge'
            )
            ->addColumn(
                'is_pct',
                Table::TYPE_BOOLEAN,
                null,
                [],
                'Is charge in percetage?'
            );

        $setup->getConnection()->createTable($table);
    }

    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $this->_setupTable($setup, $context);
        $setup->endSetup();
    }
}
