<?php

namespace EasyCSV;

/**
 * Reader - Reads from CSV files
 */
class Reader extends AbstractBase
{
    /**
     * The column headers in the CSV file
     *
     * @var array
     */
    private $_headers;

    /**
     * An internal count of how many lines have been read from the CSV file
     *
     * @var integer
     */
    private $_line;

    /**
     * A flag to specify whether to trim the values read from the CSV file
     *
     * @var boolean
     */
    private $_trimValues = true;

    /**
     * Constructor
     *
     * @param string $path      The path (including filename) of the file to read
     * @param string $delimiter The character uses as a delimiter between fields in the CSV file
     * @param string $enclosure The character used as an enclosure for fields in the CSV file
     *
     * @return void
     */
    public function __construct($path, $delimiter = ',', $enclosure = '"')
    {
        parent::__construct($path, 'r', $delimiter, $enclosure);
        $this->_line    = 0;
    }

    /**
     * Set whether to trim values read from the CSV file
     *
     * @param Boolean $trimValues A flag to specify whether to trim the values read from the CSV file
     *
     * @return void
     */
    public function setTrimValues(Boolean $trimValues)
    {
        $this->_trimValues = $trimValues;
    }

    /**
     * Set the headers
     *
     * @param array $headers The column headers
     *
     * @return void
     */
    public function setHeaders(array $headers)
    {
        $this->_headers = $headers;
    }

    /**
     * Read the headers from the CSV file
     *
     * @return void
     */
    public function readHeaders()
    {
        $this->_headers = $this->getRow();
    }

    /**
     * Get a single row from the CSV file
     *
     * @return Boolean|array False on error or end of file, array of values on successful read
     */
    public function getRow()
    {
        if (false !== ($row = fgetcsv($this->_handle, 8192, $this->_delimiter, $this->_enclosure))) {
            // empty line returns an array containing null - return just null
            if (array(null) === $row) {
                return null;
            }

            if ($this->_trimValues) {
                $row = array_map('trim', $row);
            }

            $this->_line++;

            return $this->_headers ? array_combine($this->_headers, $row) : $row;
        } else {
            // fgetcsv returned false, so we do too

            return false;
        }
    }

    /**
     * Get all the rows from the CSV file
     *
     * @return array All rows from the CSV file
     */
    public function getAll()
    {
        $data = array();
        // loop until false
        while (false !== ($row = $this->getRow())) {
            // store each row in an array (except nulls (from empty lines)
            if (null !== $row) {
                $data[] = $row;
            }
        }

        return $data;
    }

    /**
     * Get the line number most recently read
     *
     * @return integer The line number most recently read
     */
    public function getLineNumber()
    {
        return $this->_line;
    }
}
