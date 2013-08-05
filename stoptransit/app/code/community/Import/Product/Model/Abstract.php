<?php
abstract class Import_Product_Model_Abstract extends Mage_Core_Model_Abstract
{
    /**
     * Folder Settings.
     */
    const IMPORTEXPORT_DIR  = 'importexport';
    const SUCCESS_DIR  = 'success';
    const FAIL_DIR     = 'fail';
    const LOCK_DIR = 'locks';
    const LOCK_FILE = 'product_import.lock';
    const LOCK_EXPIRE_TIME = 43200; //12 hours

    /**
     * @var string Current import directory.
     */
    protected $_dir;

    /**
     * @var resource Current file handler.
     */
    protected $_fileHandler;

    /**
     * @var array If files exists, import can be started.
     */
    protected $_fileExists = array();

    /**
     * @var string Log file for import process.
     */
    protected static $_logFile = 'product_import.log';

    /**
     * @var array Files for import.
     */
    protected $_importFiles = array();

    /** @var bool Specifies if this instance has locked the process */
    protected $_lockOwner = false;

    /**
     * Sets working directory.
     *
     * @param string $dir Working directory.
     *
     * @return void
     */
    public function setWorkingDir($dir)
    {
        $this->_dir = Mage::getBaseDir('var') . DS . self::IMPORTEXPORT_DIR . DS . $dir;
    }

    /**
     * Returns working directory.
     *
     * @return string
     */
    public function getWorkingDir()
    {
        return $this->_dir;
    }


    /**
     * Check files at specified directory to start import.
     *
     * @return boolean
     */
    public function canStart()
    {
        if ($this->isLocked()) {
            return false;
        }

        $this->_importFiles = glob($this->getWorkingDir().DS.'*.csv', GLOB_BRACE);
        if (!$this->_importFiles || count($this->_importFiles) == 0) {
            return false;
        }

        foreach ($this->_importFiles as $file) {
            if (!file_exists($file))
            {
                return false;
            }
        }

        $this->createLock();

        return true;
    }

    /**
     * Check if previous import was finished.
     *
     * @return boolean
     */
    public function isLocked()
    {
        $file = Mage::getBaseDir('var') . DS . self::LOCK_DIR . DS . static::LOCK_FILE;
        if (is_file($file) && file_get_contents($file) + self::LOCK_EXPIRE_TIME > time()) {
            return true;
        }

        @unlink($file);
        return false;
    }

    /**
     * Locks import so the next one can't start until current not finished.
     *
     * @return void
     */
    public function createLock()
    {
        file_put_contents(Mage::getBaseDir('var') . DS . self::LOCK_DIR . DS . static::LOCK_FILE, time());
        $this->_lockOwner = true;
    }

    /**
     * Imports data.
     *
     * @return void
     */
    abstract public function import();

    /**
     * Move file to fail folder.
     *
     * @param string $file File which will be removed.
     *
     * @return mixed
     */
    public function fail($files)
    {
        $result ='EXCEPTION_WHEN_MOVE_FILE-' . implode(',',$files);

        foreach($files as $file) {
            try {
                $result = $this->_move(basename($file), self::FAIL_DIR);
            } catch (Exception $e) {
                self::log($e);
                continue;
            }
        }


        return $result;
    }

    /**
     * Move file to fail folder.
     *
     * @param string $file File which will be removed.
     *
     * @return mixed
     */
    public function success($files)
    {
        $result ='EXCEPTION_WHEN_MOVE_FILE-' . implode(',',$files);

        foreach($files as $file) {
            try {
                $result = $this->_move(basename($file), self::SUCCESS_DIR);
            } catch (Exception $e) {
                self::log($e);
                continue;
            }
        }
        return $result;
    }

    /**
     * Move file to destination folder.
     *
     * @param string $file        Filename of file which will be removed.
     * @param string $destination New destination of file.
     *
     * @throws Exception
     *
     * @return string
     */
    protected function _move($file, $destination)
    {

        $path = $this->getWorkingDir() . DS . $file;

        if (!file_exists($path)) {
            return false;
        }

        $dir = $this->getWorkingDir(). DS . $destination;
        if (!file_exists($dir)) {
            mkdir($dir);
            chmod($dir, 0777);
            if (!is_dir($dir)) {
                throw new Exception('Can\'t create folder: ' . $dir);
            }
        }

        $pos = strrpos($file, '.');
        $filename = substr($file, 0, $pos);
        $ext = substr($file, $pos);

        $fullPathMovedFile = $dir . DS . $filename . '_' . date('Ymd') . '_' .date('His') . $ext;
        $umask = umask(0);
        if (!$result = rename($path, $fullPathMovedFile)) {
            throw new Exception('Can\'t move file: ' . $path);
        }
        umask($umask);

        return $fullPathMovedFile;
    }

    /**
     * Saves error message to log file.
     *
     * @param string $msg Error message.
     *
     * @return void
     */
    static public function log($msg)
    {
        $pid = function_exists('posix_getpid') ? posix_getpid() : getmypid();
        Mage::log('(' . $pid . ') ' . $msg, null, static::$_logFile, true);
    }

    /**
     * Delete ok files.
     */
    public function __destruct()
    {
        if (!$this->_lockOwner) {
            return;
        }

        @unlink(Mage::getBaseDir('var') . DS . self::LOCK_DIR . DS . static::LOCK_FILE);

//        foreach ($this->_importFiles as $file) {
//            @unlink($this->getWorkingDir() . DS . $file);
//        }
    }
}