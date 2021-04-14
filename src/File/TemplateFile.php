<?php namespace Tschallacka\MageRain\File;

/**
 * Simple templating file handler
 * @author tschallacka
 *
 */
class TemplateFile extends File 
{
    protected $destination;
    public function __construct($path, $destination) 
    {
        parent::__construct($path);
        $this->destination = $destination;
    }
    
    public function load() 
    {
        if($this->path == $this->destination) throw new \Exception("Do not call load() the same template instance twice.");
        parent::load();
        $this->path = $this->destination;
        $this->directory = new Directory(dirname($this->destination));
    }
    
    public function save($variables = []) 
    {
        $this->data = vsprintf($this->data, $variables);
        parent::save();
    }
}