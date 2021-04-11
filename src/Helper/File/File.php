<?php namespace Tschallacka\MageRain\Helper\File;

use Exception;
use Tschallacka\MageRain\Helper\File\Transformer\Transformer;

class File 
{
    protected $path;
    
    /**
     * @var $directory \Tschallacka\MageRain\Helper\File\Directory
     */
    protected $directory;
    
    protected $data;
    
    protected $transformers = [];
    
    public function __construct($path) 
    {
        $this->path = $path;
        $this->directory = new Directory(dirname($path));
    }
    
    /**
     * Returns the parent directory of the file
     * @return \Tschallacka\MageRain\Helper\File\Directory
     */
    public function getDirectory() 
    {
        return $this->directory;    
    }
    
    /**
     * Reads the data fresh from disk, overwrites any cached data within 
     * the data object
     */
    public function load() 
    {
        $this->data = $this->readRaw();    
    }
    
    /**
     * Writes the cached data to disk.
     */
    public function save() 
    {
        $this->writeRaw($this->data);    
    }
    
    public function addTransformer(Transformer $transform)
    {
        $this->transformers[] = $transform;
    }
    
    /**
     * returns the data as it is stored in this file object
     * @return string
     */
    public function getData() 
    {
        return $this->data;
    }
    
    /**
     * Sets the data as it is in here to the buffer.
     * @param string $data
     */
    public function setData($data) 
    {
        $this->data = $data;
    }
    
    /**
     * Writes the raw string data to disk
     * @param string $contents
     * @throws Exception when the directory doesn't exist.
     */
    public function writeRaw($contents) 
    {
        if(!$this->directory->exists()) {
            throw new Exception('Directory ' . $this->directory->getPath() . ' does not exist');
        }
        foreach($this->transformers as $transformer) {
            $contents = $transformer->getTransformedText($contents);
        }
        file_put_contents($this->path, $contents);    
    }
    
    /**
     * Reads string data from disk
     * @return string
     */
    public function readRaw() 
    {
        $contents = file_get_contents($this->path);
        return $contents;
    }
    
}