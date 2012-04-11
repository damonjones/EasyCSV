<?php

namespace EasyCSV\Tests;

require_once __DIR__ . '/TestInit.php';

class WriterTest extends \PHPUnit_Framework_TestCase
{
    private $_writer;

    public function setUp()
    {
        $this->_writer = new \EasyCSV\Writer(__DIR__.'/write.csv');
    }

    public function testWriteRowFromString()
    {
        $this->_writer->writeRow('test1, test2, test3');
        unset($this->_writer);

        $reader = new \EasyCSV\Reader(__DIR__.'/write.csv');
        $results = $reader->getRow();

        $expected = array('test1', 'test2', 'test3');
        $this->assertEquals($expected, $results);
    }

    public function testWriteRowFromArray()
    {
        $data = array('test1', 'test2', 'test3');
        $this->_writer->writeRow($data);
        unset($this->_writer);

        $reader = new \EasyCSV\Reader(__DIR__.'/write.csv');
        $results = $reader->getRow();

        $this->assertEquals($data, $results);
    }

    public function testWriteFromArray()
    {
        $data = array(
            array(
                'column1' => '1test1',
                'column2' => '1test2ing this out',
                'column3' => '1test3'
            ),
            array(
                'column1' => '2test1',
                'column2' => '2test2 ing this out ok',
                'column3' => '2test3'
            )
        );

        $this->_writer->writeFromArray($data);
        unset($this->_writer);

        $reader = new \EasyCSV\Reader(__DIR__.'/write.csv');
        $reader->readHeaders();
        $results = $reader->getAll();

        $this->assertEquals($data, $results);
    }
}
