<?php

namespace EasyCSV;

class Reader extends AbstractBase
{
    private $_headers;
    private $_line;
    private $_trimValues = true;

    public function __construct($path, $delimiter = ',', $enclosure = '"')
    {
        parent::__construct($path, 'r', $delimiter, $enclosure);
        $this->_line    = 0;
    }

    public function setTrimValues(Boolean $trimValues)
    {
        $this->_trimValues = $trimValues;
    }

    public function setHeaders(array $headers)
    {
        $this->_headers = $headers;
    }

    public function readHeaders()
    {
        $this->_headers = $this->getRow();
    }

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

    public function getLineNumber()
    {
        return $this->_line;
    }
}
