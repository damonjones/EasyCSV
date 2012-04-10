<?php

namespace EasyCSV;

class Writer extends AbstractBase
{
    public function __construct($path, $delimiter = ',', $enclosure = '"')
    {
        parent::__construct($path, 'w+', $delimiter, $enclosure);
    }

    public function writeRow($row)
    {
        if (is_string($row)) {
            $row = explode($this->_delimiter, $row);
            $row = array_map('trim', $row);
        }

        return fputcsv($this->_handle, $row, $this->_delimiter, $this->_enclosure);
    }

    public function writeFromArray(array $array, $write_headers = true)
    {
        if ($write_headers) {
            $this->writeRow(array_keys($array[0]));
        }

        foreach ($array as $key => $value) {
            $this->writeRow($value);
        }
    }
}
