<?php namespace Tschallacka\MageRain\File\Format;

use Tschallacka\MageRain\File\JsonFile;

class Composer extends JsonFile 
{   
    
    public function initializeEmptyFile() 
    {
        $this->name = $this->get('name', '');
        $this->authors = $this->get('authors', []);
        $this->description = $this->get('description', 'A composer package');
        $this->license = $this->get('license', '');
        $this->version = $this->get('version', '1.0.0');
        $this->require = $this->get('require', []);
        $this->autoload = $this->get('autoload', ['psr-4' => []]);
    }
    
    public function addAuthor($name, $email = null) 
    {
        $authors = $this->authors;
        $existing = array_filter($authors, function($item) use($name) { return $item['name'] == $name;});
        
        if(!count($existing)) {
            $entry = [
                'name' => $name,
            ];
            if($email) $entry['email'] = $email;
            $authors[] = $entry;
            $this->authors = $authors; 
        }
    }
    
    
}