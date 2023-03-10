<?php
/**
 * Its a csv file iterator class which has implemented 
 * Iterator interface. This is an example of iterator design pattern
 */

class CsvFileIterator implements Iterator {
    protected $file;
    protected $key = 0;
    protected $current;
 
    public function __construct($file) {
        $this->file = fopen($file, 'r');
    }
 
    public function __destruct() {
        fclose($this->file);
    }
 
    public function rewind() {
        rewind($this->file);
        $this->current = fgetcsv($this->file);
        $this->key = 0;
    }
 
    public function valid() {
        return !feof($this->file);
    }
 
    public function key() {
        return $this->key;
    }
 
    public function current() {
        return $this->current;
    }
 
    public function next() {
        if ($rec = fgetcsv($this->file)) {
            $this->current = $rec;
            $this->key++;
        }
    }
}
?>