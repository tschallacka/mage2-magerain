<?php namespace Tschallacka\MageRain\Module;

use Magento\Framework\Module\ModuleListInterface;
use Tschallacka\MageRain\Helper\Text\Str;
use Tschallacka\MageRain\File\Directory;

class ModuleInfo 
{
    protected $module_name;
    protected $author_name;
    protected $hyphen_module_name;
    protected $hyphen_author_name;
    protected $raw_name;
    
    public function __construct($raw_name, ModuleListInterface $module_list)
    {
        $this->module_list = $module_list;
        $helper = new ModuleHelper($module_list);
        $helper->checkModuleNameValidity($raw_name);
        
        $this->raw_name = $raw_name;
        
        $parts = explode('_', $raw_name);
        $this->author_name = $parts[0];
        $this->module_name = $parts[1];
        $this->hyphen_author_name = $this->hyphenate($this->author_name);
        $this->hyphen_module_name = $this->hyphenate($this->module_name);
    }  
    
    protected function hyphenate($str)
    {
        return str_replace("_", "-", Str::snake($str));
    }
    
    /**
     * Returns a directory instance
     * @var $vendor_path string When null magento's default vendor dir will be used as vendor path. Otherwise the supplied path will be used.
     * @return \Tschallacka\MageRain\File\Directory
     */
    protected function getVendorPath($vendor_path = null)
    {
        $author = $this->hyphen_author_name;
        $module = $this->hyphen_module_name;
        
        $vendor_path_author = (is_null($vendor_path) ? Directory::getMagentoVendorDir() : $vendor_path) . '/' . $author;
        
        $project_path_vendor = $vendor_path_author . '/' . $module;
        
        return new Directory($project_path_vendor);
    }
    
    /**
     * Returns the module name as Magento likes it, Author_Module
     * @return string
     */
    public function getMagentoModuleName()
    {
        return $this->raw_name;
    }
    
    public function getNameSpace()
    {
        return $this->author_name . '\\' . $this->module_name;
    }
    
    public function getPackageName()
    {
        return $this->hyphen_author_name . '/' . $this->hyphen_module_name;
    }
    
    /**
     * Get the author name
     * @return String
     */
    public function getAuthorName()
    {
        return $this->author_name;
    }
    
    /**
     * Return the package name
     * @return string
     */
    public function getModuleName()
    {
        return $this->module_name;
    }
    
    /**
     * Get the author name, hyphenated
     * @return String
     */
    public function getHyphenAuthorName()
    {
        return $this->hyphen_author_name;
    }
    
    /**
     * Return the package name, hyphenated
     * @return string
     */
    public function getHyphenModuleName()
    {
        return $this->hyphen_module_name;
    }
}