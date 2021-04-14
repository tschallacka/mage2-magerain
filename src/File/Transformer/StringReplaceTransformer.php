<?php namespace Tschallacka\MageRain\File\Transformer;

class StringReplaceTransformer implements Transformer 
{
    protected $find_replace = [];
    
    public function __construct($find, $replace) 
    {
        if($find && $replace) {
            
            if(is_array($find) && is_array($replace)) {
                foreach($find as $key => $value) {
                    $this->find_replace[$value] = $replace[$key];
                }
            }
            else if(is_array($find) && is_string($replace)) {
                foreach($find as $value) {
                    $this->find_replace[$value] = $replace;
                }
            }
            else if(is_string($find) && is_array($replace)) {
                throw new \InvalidArgumentException('Provided string for find, array for replacement, how is this supposed to match?');
            }
            else if(is_string($find) && is_string($replace)) {
                $this->find_replace[$find] = $replace;
            }
            else {
                $this->invalidArgument();
            }
        }
        else {
            $this->invalidArgument();
        }
    }
    
    private function invalidArgument() 
    {
        throw new \InvalidArgumentException('No valid find and replace values provided!');
    }
    
    public function getTransformedText($input) 
    {
        return strtr($input, $this->find_replace);
    }
}