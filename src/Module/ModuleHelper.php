<?php namespace Tschallacka\MageRain\Module;

use \Magento\Framework\Module\ModuleListInterface;
use InvalidArgumentException;

class ModuleHelper 
{
    /**
     * @var ModuleListInterface
     */
    protected $module_list;
    
    public function __construct(ModuleListInterface $module_list) 
    {
        $this->module_list = $module_list;    
    }
    /**
     * Checks wether an module name argument is given at all
     * Checks wether the given string is a valid argument to provide to this command
     * checks wether the given module already exists in this magento installation
     * @param string $name
     * @throws \InvalidArgumentException when the given module name does not meet the criterea
     * @return boolean
     */
    public function checkModuleNameValidity($name)
    {
        if (is_null($name) || empty($name)) {
            throw new InvalidArgumentException('The module name is empty or not provided');
        }
        
        $pos = strpos($name, '_');
        if($pos === false || $pos === 0 || $pos == strlen($name) - 1) {
            throw new InvalidArgumentException('The module name needs to be in format AuthorName_ModuleName instead "'.$name.'" was provided.');
        }
        
        if($this->module_list->has($name)) {
            throw new InvalidArgumentException('The module '. $name .' already exists. Please use another module name.');
        }
        
        return true;
    }
}