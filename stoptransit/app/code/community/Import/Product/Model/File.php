<?php
/**
 * User: v.kondratyuk
 * Date: 2/18/12
 * Time: 11:27 AM
 */

class Import_Product_Model_File
{
    /**
     * Parser settings.
     */
    const CSV_INPUT_DELIMITER = '|';
    const CSV_INPUT_ENCLOSURE = '"';
    const CSV_OUTPUT_DELIMITER = ',';
    const CSV_OUTPUT_ENCLOSURE = '"';

    /**
     * @var int Current row in file.
     */
    protected $_row = 1;

    /**
     * @var string Current import directory.
     */
    protected $_dir;

    /**
     * @var resource Current file handler.
     */
    protected $_fileHandler;

    /**
     * @var array Headers of file.
     */
    protected $_headerCols;

    /**
     * @var string Current file.
     */
    protected $_file;

    protected $_iconvCharset = '';

    /**
     * Open file handler.
     *
     * @param string $file File to open.
     * @param string $mode Mode for opened file.
     *
     * @return ISM_Import_Model_File
     */
    public function fopen($file, $mode)
    {
        $umask = umask(0);

        $this->_file = $file;
        $this->_fileHandler = fopen($this->_file, $mode);

        umask($umask);

        if (!$this->_fileHandler) {
            throw new Exception('Cannot open input file: '. $this->_file);
        }

        return $this;
    }

    /**
     * Close file handler.
     *
     * @return ISM_Import_Model_File
     *
     * @see fclose();
     */
    public function fclose()
    {
        if (is_resource($this->_fileHandler)) {
            fclose($this->_fileHandler);
        }

        return $this;
    }

    /**
     * Return row from handler file and mapping row.
     *
     * @return array
     */
    public function getRow()
    {
        $this->_row = $this->_row + 1;
        return fgetcsv($this->_fileHandler, null, self::CSV_INPUT_DELIMITER, self::CSV_INPUT_ENCLOSURE);
    }

    /**
     * Return current row index in file.
     *
     * @return integer
     */
    public function getRowIndex()
    {
        return $this->_row;
    }

    /**
     * Return row from handler file.
     *
     * @param array $rowData Row of data for output file.
     *
     * @return object
     */
    public function writeRow(array $rowData)
    {
        if (
            fputcsv(
                $this->_fileHandler,
                array_merge($this->_headerCols, array_intersect_key($rowData, $this->_headerCols)),
                self::CSV_OUTPUT_DELIMITER,
                self::CSV_OUTPUT_ENCLOSURE
            ) === false
        ) {
            throw new Exception('Cannot write to: ' . $this->_file);
        }

        return $this;
    }

    /**
     * Set headers for output file.
     *
     * @param array $headerCols Row of data with header names.
     *
     * @return object
     */
    public function setHeaderCols(array $headerCols)
    {
        if (null !== $this->_headerCols) {
            throw new Exception('Header column names already set');
        }
        if ($headerCols) {
            foreach ($headerCols as $colName) {
                $this->_headerCols[$colName] = false;
            }
            $this->writeHeaderRow();
        }
        return $this;
    }

    /**
     * Write header Row to the output file
     *
     * @return \ISM_Import_Model_File
     */
    public function writeHeaderRow()
    {
        fputcsv(
            $this->_fileHandler,
            array_keys($this->_headerCols),
            self::CSV_OUTPUT_DELIMITER,
            self::CSV_OUTPUT_ENCLOSURE
        );

        return $this;
    }

    /**
     * Explode given file to array, using str_getcsv.
     *
     * If $_iconvCharset is set to not empty value, it will be used
     * to convert string data to Mage_Core_Helper_String::ICONV_CHARSET.
     *
     * @param string $file Path to file.
     *
     * @return array
     *
     * @see Mage_Core_Helper_String::ICONV_CHARSET
     */
    public function fileToArray($file)
    {
        $content = file_get_contents($file);

        if (!empty($this->_iconvCharset)) {
            $content = iconv($this->_iconvCharset, Mage_Core_Helper_String::ICONV_CHARSET, $content);
        }

        $array = explode("\n", $content);
        unset($content);

        if ($array[count($array) - 1] == '') {
            unset($array[count($array) - 1]);
        }

        foreach ($array as $key => $item) {
            $array[$key] = str_getcsv($item, self::CSV_INPUT_DELIMITER, self::CSV_INPUT_ENCLOSURE);
        }

        return $array;
    }

    /**
     * Close file handler.
     */
    public function __destruct()
    {
        $this->fclose();
    }

    /**
     * Set Input charset for file content convertion.
     *
     * @param string $iconvCharset Input charset.
     *
     * @return boolean
     */
    public function setIconvCharset($iconvCharset)
    {
        $oldValue = $this->_iconvCharset;

        $this->_iconvCharset = $iconvCharset;

        return $oldValue;
    }

    /**
     * Return current input charset.
     *
     * @return string
     */
    public function getIconvCharset()
    {
        return $this->_iconvCharset;
    }
}
 