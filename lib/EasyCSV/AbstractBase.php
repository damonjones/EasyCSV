<?php

namespace EasyCSV;

abstract class AbstractBase
{
    protected $_handle;
    protected $_delimiter;
    protected $_enclosure;

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

    public function __destruct()
    {
        if (is_resource($this->_handle)) {
            fclose($this->_handle);
        }
    }

    public function setDelimiter($delimiter)
    {
        $this->_delimiter = $delimiter;

        return $this;
    }

    public function setEnclosure($enclosure)
    {
        $this->_enclosure = $enclosure;

        return $this;
    }
}
