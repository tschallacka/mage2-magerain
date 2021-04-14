<?php namespace Tschallacka\MageRain\Helper\Module;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Module\FullModuleList;
use InvalidArgumentException;

class ModuleHelper 
{
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
            throw new InvalidArgumentException('Argument ' . self::MODULE_NAME_ARGUMENT . ' is missing.');
        }
        
        $pos = strpos($name, '_');
        if($pos === false || $pos === 0 || $pos == strlen($name) - 1) {
            throw new InvalidArgumentException('Argument ' . self::MODULE_NAME_ARGUMENT . ' needs to be in format AuthorName_ModuleName instead "'.$name.'" was provided.');
        }
        
        $list = ObjectManager::getInstance()->create(FullModuleList::class);
        if($list->has($name)) {
            throw new InvalidArgumentException('The module '. $name .' already exists. Please use another module name.');
        }
        
        return true;
    }
}