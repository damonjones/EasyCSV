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
     * @param string  $path       The path (including filename) of the file to read
     * @param string  $delimiter  The character uses as a delimiter between fields in the CSV file
     * @param string  $enclosure  The character used as an enclosure for fields in the CSV file
     * @param Boolean $hasHeaders If there are column headers at the start of the CSV file
     *
     * @return void
     */
    public function __construct($path, $delimiter = ',', $enclosure = '"', $hasHeaders = true)
    {
        parent::__construct($path, 'r', $delimiter, $enclosure);
        if ($hasHeaders) {
            $this->_headers = $this->getRow();
        }
        $this->_line = 0;
    }

    /**
     * Set whether to trim values read from the CSV file
     *
     * @param Boolean $trimValues A flag to specify whether to trim the values read from the CSV file
     *
     * @return object
     */
    public function setTrimValues(Boolean $trimValues)
    {
        $this->_trimValues = $trimValues;

        return $this;
    }

    /**
     * Set the headers
     *
     * @param array $headers The column headers
     *
     * @return object
     */
    public function setHeaders(array $headers)
    {
        $this->_headers = $headers;

        return $this;
    }

    /**
     * Get a single row from the CSV file
     *
     * @return array|Boolean|null An array of values on successful read, null for an empty row or false on an error or end of file
     */
    public function getRow($maxLength = 0)
    {
        $row = @fgetcsv($this->_handle, $maxLength, $this->_delimiter, $this->_enclosure);

        if (null === $row) {
            throw new \Exception('Invalid file handle.');
        }

        // fgetcsv returned false, so we do too (error or end of file)
        if (false === $row) {
            return false;
        }

        // an empty line returns an array containing null, so we'll return just null instead
        if (array(null) === $row) {
            return null;
        }

        if ($this->_trimValues) {
            $row = array_map('trim', $row);
        }

        $this->_line++;

        $arr = $this->_headers ? @array_combine($this->_headers, $row) : $row;

        if (false === $arr) {
            throw new \Exception('Number of keys and columns must match.');
        }

        return $arr;
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
            // store each row in an array (except nulls which are from empty lines)
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
