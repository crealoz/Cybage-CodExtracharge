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

namespace Cybage\CodExtracharge\Model;

use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\File\Csv;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Exception\LocalizedException;
use Cybage\CodExtracharge\Api\CashondeliveryTableInterface;
use Magento\Store\Model\StoreManagerInterface;

class CashondeliveryTable extends AbstractModel implements CashondeliveryTableInterface
{
    /* protected Magento\Framework\File\Csv $csv */
    protected $csv;

    /* @var type  Magento\Framework\Filesystem $filesystem*/
    protected $filesystem;

    /* @var type Magento\Framework\Filesystem\Driver\File $file*/
    protected $file;

    /* @var type Magento\Store\Model\StoreManagerInterface */
    protected $storeManager;

    /* @var array $_columns */
    public $_columns = ['website', 'country', 'amount_above', 'amount_max', 'cod_charge', 'is_pct'];

    /**
     * Constructor
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param Csv $csv
     * @param Filesystem $filesystem
     * @param File $file
     * @param StoreManagerInterface $storeManager
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        Csv $csv,
        Filesystem $filesystem,
        File $file,
        StoreManagerInterface $storeManager,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->csv = $csv;
        $this->filesystem = $filesystem;
        $this->file = $file;
        $this->storeManager = $storeManager;
    }

    /**
     * constructor
     */
    protected function _construct()
    {
        $this->_init('Cybage\CodExtracharge\Model\ResourceModel\CashondeliveryTable');
    }

    /**
     * Get cash on delivery fee
     *
     * @param double $amount
     * @param string $country
     * @param string $region
     * @return double
     */
    public function getCodCharge($amount, $country)
    {
        return $this->_getResource()->getFee($amount, $country);
    }

    /**
     * Get table as array
     *
     * @return array
     */
    public function getTableAsArray()
    {
        return $this->_getResource()->getTableAsArray();
    }

    /**
     * Get table as CSV
     *
     * @return string
     */
    public function getTableAsCsv()
    {
        $data = $this->getTableAsArray();

        $tmpDir = $this->filesystem->getDirectoryWrite(DirectoryList::TMP);
        $fileName = $tmpDir->getAbsolutePath(uniqid(md5(time())).'.csv');

        $dataOut = [$this->_columns];
        foreach ($data as $row) {
            $dataOutRow = [];
            foreach ($this->_columns as $column) {
                if (($column == 'cod_charge') && ($row['is_pct'])) {
                    $dataOutRow[] = $row[$column].'%';
                } else {
                    $dataOutRow[] = $row[$column];
                }
            }
            $dataOut[] = $dataOutRow;
        }

        $this->csv->saveData($fileName, $dataOut);

        $res = $this->file->fileGetContents($fileName);
        $this->file->deleteFile($fileName);

        return $res;
    }

    /**
     * Save from file
     *
     * @param string $fileName
     * @return int
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function saveFromFile($fileName)
    {
        $tmpDirectory = $this->filesystem->getDirectoryRead(DirectoryList::SYS_TMP);
        $path = $tmpDirectory->getRelativePath($fileName);
        $stream = $tmpDirectory->openFile($path);
        $headers = $stream->readCsv();
        if ($headers === false || count($headers) < count($this->_columns)) {
            $stream->close();
            throw new LocalizedException(__('Invalid columns count.'));
        }

        $columnsMap = array_flip($headers);

        $data = [];

        $rowNumber = 0;
        while (false !== ($csvLine = $stream->readCsv())) {
            if (empty($csvLine)) {
                continue;
            }

            $rowNumber++;

            $dataRow = [];

            for ($i=0; $i < count($headers); $i++) {
                foreach ($this->_columns as $columnName) {
                    if ($columnName == 'website') {
                        if (!isset($csvLine[$columnsMap[$columnName]]) || !$csvLine[$columnsMap[$columnName]]) {
                            $csvLine[$columnsMap[$columnName]] = '*';
                        }
                    }
                    $value = $csvLine[$columnsMap[$columnName]];
                    if ($columnName == 'cod_charge') {
                        $dataRow['is_pct'] = (strpos($value, '%') !== false);
                        $value = floatval(str_replace('%', '', $value));
                    } else if ($columnName == 'amount_above') {
                        $value = floatval($value);
                    } else if ($columnName == 'amount_max') {
                        $value = floatval($value);
                    }
                    $dataRow[$columnName] = $value;
                }
            }
            $data[] = $dataRow;
        }
        
        if ($this->validateRange($data)) {
            $this->_getResource()->populateFromArray($data);
            return $rowNumber;
        }
    }

    /**
     * Get number of rows
     * @return int
     */
    public function getRowsCount()
    {
        return $this->_getResource()->getRowsCount();
    }

    /**
     * Validate the csv amount_above and amount_max range
     * @param type $rules
     * @return boolean
     * @throws LocalizedException
     */
    public function validateRange($rules)
    {
        if (empty($rules)) {
            throw new LocalizedException(__('Empty csv file'));
        }
        
        $rulesdata = $rules;
        $rowNum = 0;
        foreach ($rules as $rule) {
            $rowNum++;
            $j = 0;
            if ($this->validateRow($rule, $rowNum)) {
                foreach ($rulesdata as $ruledata) {
                    $j++;
                    if (($i != $j) && (strcmp($rule['website'],$ruledata['website']) == 0) && (strcmp($rule['country'], $ruledata['country']) == 0)) {
                        if (($rule['amount_above'] > $ruledata['amount_max']) || (($rule['amount_above'] < $ruledata['amount_max']) && ($rule['amount_max'] < $ruledata['amount_max']))) {
                            continue;
                        } else {
                            throw new LocalizedException(__('Invalid amount min-max range at row %1', [$j]));
                        }
                    }
                }
            }
        }
        return true;
    }

    /**
     * Validate row
     * @param type $rowData
     * @param type $rowNum
     */
    public function validateRow($row, $rowNum)
    {
        $websites = $this->getAllWebsiteCodes();
        if ($row['amount_max'] >= 0 && $row['amount_above'] >= 0 && $row['cod_charge'] >= 0) {
            if ($row['amount_max'] < $row['amount_above']) {
                throw new LocalizedException(__('Invalid amount range at row %1', [$rowNum]));
            }
            if (!in_array(trim($row['website']), $websites)) {
                throw new LocalizedException(__('Invalid website code at row %1', [$rowNum]));
            }
        } else {
            throw new LocalizedException(__('Invalid numbers at row %1', [$rowNum]));
        }
    }

    /**
     * Get all websites of system
     * @return type array
     */
    public function getAllWebsiteCodes()
    {
        $data = array();
        $websiteCollection = $this->storeManager->getWebsites();
        foreach ($websiteCollection as $website) {
            $data[] = trim($website->getCode());
        }
        array_push($data, '*');
        return $data;
    }
}
