<?php namespace Tschallacka\MageRain\File;

use Exception;

class Directory 
{
    const BASE_PATH = BP;
    protected $directory;
    
    /**
     * @param string $directory The directory path
     */
    public function __construct(string $directory) 
    {
        if(substr($directory, -1) === DIRECTORY_SEPARATOR) {
            $directory = substr($directory, 0, -1);
        }
        $this->directory = $directory;
    }
    
    /**
     * Returns the path as it's defined in VENDOR_PATH(app/etc/vendor_path.php) in a realpath format
     * @return string full path to the vendor dir.
     */
    public static function getMagentoVendorDir()
    {
        static $dir = null;
        // Needs to be like this because of no operation allowed in constants error
        if(!$dir) {
            $dir = realpath(require(VENDOR_PATH));
        }
        return $dir;
    }
    
    public function exists() 
    {
        return file_exists($this->directory) && is_dir($this->directory);    
    }
    
    /**
     * Creates the given directory recusively, building up the entire
     * parent structure if needed.
     * @throws Exception if the directory aldready exists
     * @return \Tschallacka\MageRain\File\Directory
     */
    public function create() 
    {
        if($this->exists()) {
            throw new Exception($this->directory . ' already exists.');
        }
        self::mkdir_r($this->directory);
        return $this;
    }
    
    public function getPath($child_path = '') 
    {
        return $this->directory . $this->sanitzeChildPath($child_path);    
    }
    
    public function sanitzeChildPath($child_path = '')
    {
        return (empty($child_path) ? '' : 
                ((substr( $child_path, 0, 1 ) == DIRECTORY_SEPARATOR)?'':DIRECTORY_SEPARATOR) . $child_path);
    }
    
    /**
     * Returns the parent directory of the current directory
     * @return \Tschallacka\MageRain\File\Directory
     */
    public function getParent() 
    {
        if($this->directory == '/') {
            return null;
        }
        return new self(dirname($this->directory));
    }
    
    /**
     * Gets a child directory. This directory may not exist.
     * @param string $name
     * @return \Tschallacka\MageRain\File\Directory
     */
    public function getChild($name) 
    {
        $path = new Directory($this->getPath($name));
        return $path;
    }
    
    public function equals(Directory $dir) 
    {
        return $dir->directory === $this->directory;    
    }
    
    /**
     * Creates given directory in current directory
     * @param string $dirname
     * @return \Tschallacka\MageRain\File\Directory
     */
    public function createChildDirectory($dirname) 
    {
        $path = $this->getChild($dirname);
        if(!$path->exists()) {
            $path->create();
        }
        return $path;
    }
    
    
    
    /**
     * Returns a list of all directories as Dirctory instance and files as strings
     * @return \Tschallacka\MageRain\File\Directory[]|string[]
     */
    public function getChildren() 
    {
        $results = scandir($this->directory);
        $output = [];
        foreach($results as $result) 
        {
            if($result == '.' || $result == '..') continue;
            $path = $this->directory . DIRECTORY_SEPARATOR . $result;
            $output[] = is_dir($path) ? new Directory($path) : $path;
        }
        return $output;
    }
    
    /**
     * Creates the given directory recursively
     * @param string $dirName
     * @param the rights to give the directory $rights
     */
    public static function mkdir_r($dirName, $rights = 0777)
    {
        if (!is_dir($dirName)) {
            $dirs = explode(DIRECTORY_SEPARATOR, $dirName);
            $dir = '';
            if (strpos($dirs[count($dirs) - 1], '.')) {
                array_pop($dirs);
            }
            foreach ($dirs as $part) {
                $dir .= $part . DIRECTORY_SEPARATOR;
                if (! is_dir($dir) && strlen($dir) > 0) {
                    if(!@mkdir($dir, $rights)) {
                        $error = error_get_last();
                        throw new Exception('Error during mkdir() '. $dir . PHP_EOL . $error);
                    }
                }
            }
        }
    }
    
    public function __toString() 
    {
        return $this->directory;    
    }
}