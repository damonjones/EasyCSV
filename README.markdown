# EasyCSV

Set of PHP 5.3 classes for reading and writing CSV files.

## Reader

To read CSV files we need to instantiate the EasyCSV reader class:

    $reader = new \EasyCSV\Reader('read.csv');

If the first row of the file has column names, they will be read and used as keys for the returned row data.
If the file doesn't have a header row then you can pass a flag in the constructor to disable this behaviour.
If you want to manually set the headers, then pass an array of column names:

    $reader->setHeaders(array('column1', 'column2', 'column3'));

If headers are set, each row of returned data will be an associative array with the column names as keys.

You can iterate over the rows one at a time:

    while ($row = $reader->getRow()) {
        print_r($row);
    }

Or you can get everything all at once:

    print_r($reader->getAll());

## Writer

To write CSV files we need to instantiate the EasyCSV writer class:

    $writer = new \EasyCSV\Writer('write.csv');

You can write a row by passing a comma-separated string:

    $writer->writeRow('column1, column2, column3');

Or you can pass an array:

    $writer->writeRow(array('column1', 'column2', 'column3'));

You can also write several rows at once:

    $writer->writeFromArray(array(
            'value1, value2, value3',
            array('value1', 'value2', 'value3')
    ));

## TAB or other-delimited files
Both Reader and Writer classes will accept a delimiter character (default ',') and an enclosure character (default '"').
In this case, you should replace the comma with whichever delimeter you have set in all the examples above.
