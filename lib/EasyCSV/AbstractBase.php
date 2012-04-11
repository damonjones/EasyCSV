<?php

namespace EasyCSV;

/**
 * An abstract base class for EasyCSV
 */
abstract class AbstractBase
{
    /**
     * The handle to the file to access
     * @var resource
     */
    protected $_handle;

    /**
     * The character used as a delimiter between fields in the CSV file
     * @var string
     */
    protected $_delimiter;

    /**
     * The character used as an enclosure for fields in the CSV file
     * @var string
     */
    protected $_enclosure;

    /**
     * Constructor
     * @param string $path      The path (including filename) of the file to access
     * @param string $mode      The mode with which to access the file (see http://php.net/manual/en/function.fopen.php)
     * @param string $delimiter The character used as a delimiter between fields in the CSV file
     * @param string $enclosure The character used as an enclosure for fields in the CSV file
     *
     * @return void
     */
    public function __construct($path = null, $mode = 'r+', $delimiter = ',', $enclosure = '"')
    {
        if (null === $path) {
            throw new \Exception('Path cannot be empty.');
        }

        if ($this instanceof Writer && !file_exists($path)) {
            if (!(touch($path))) {
                throw new \Exception('Path does not exist and could not be created.');
            }
        }

        // E_WARNING may be generated
        if (false === ($this->_handle = fopen($path, $mode))) {
            throw new \Exception('File could not be opened.');
        }

        $this->_delimiter = $delimiter;
        $this->_enclosure = $enclosure;
    }

    /**
     * Destructor
     * Closes the file handle if there is one open
     *
     * @return void
     */
    public function __destruct()
    {
        if (is_resource($this->_handle)) {
            fclose($this->_handle);
        }
    }

    /**
     * Set the delimiter
     * @param string $delimiter The character uses as a delimiter between fields in the CSV file
     *
     * @return object
     */
    public function setDelimiter($delimiter)
    {
        $this->_delimiter = $delimiter;

        return $this;
    }

    /**
     * Set the enclosure
     * @param string $enclosure The character used as an enclosure for fields in the CSV file
     *
     * @return object
     */
    public function setEnclosure($enclosure)
    {
        $this->_enclosure = $enclosure;

        return $this;
    }
}
