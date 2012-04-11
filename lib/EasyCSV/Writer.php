<?php

namespace EasyCSV;

/**
 * Writer - Writes to CSV files
 */
class Writer extends AbstractBase
{
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
        parent::__construct($path, 'w+', $delimiter, $enclosure);
    }

    /**
     * Write a row to the CSV file
     *
     * @param string|array $row A delimited string or array of values to write to the CSV file
     *
     * @return integer|Boolean      Returns the length of the written string on success, or false on failure
     */
    public function writeRow($row)
    {
        if (is_string($row)) {
            $row = explode($this->_delimiter, $row);
            $row = array_map('trim', $row);
        }

        return fputcsv($this->_handle, $row, $this->_delimiter, $this->_enclosure);
    }

    /**
     * Write multiple rows to the CSV file, optionally writing the header row
     *
     * @param array   $array        An array of values to write
     * @param boolean $writeHeaders Whether to use the array keys to write a row of headers to the CSV file
     *
     * @return void
     */
    public function writeFromArray(array $array, $writeHeaders = true)
    {
        if ($writeHeaders) {
            $this->writeRow(array_keys($array[0]));
        }

        foreach ($array as $key => $value) {
            $this->writeRow($value);
        }
    }
}
