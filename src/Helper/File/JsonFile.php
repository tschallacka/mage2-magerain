<?php namespace Tschallacka\MageRain\Helper\File;

use Adbar\Dot;

class JsonFile extends File 
{
    /**
     * @var $data \Adbar\Dot
     */
    
    public function load() 
    {
        parent::load();
        $this->data = new Dot(json_decode($this->data));
    }
    
    public function save() 
    {
        $raw_data = $this->data;
        $this->data = json_encode($this->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        parent::save();
        $this->data = $raw_data;
    }
    
    public function get($key, $default = null) 
    {
        if(is_null($this->data)) $this->data = new Dot();
        return $this->data->get($key, $default);
    }
    
    public function put($key, $new_data) 
    {
        if(is_null($this->data)) $this->data = new Dot();
        $this->data->set($key, $new_data);
    }
    
    public function __get($key) 
    {
        return $this->get($key);    
    }

    public function __set($key, $value)
    {
        return $this->put($key, $value);
    }
}