<?php namespace Tschallacka\MageRain\Helper\Text;

class Str 
{
    private static $camel_cache = [];
    private static $studly_cache = [];
    
    public static function snake($value) 
    {
        if(isset(self::$camel_cache[$value])) {
            return self::$camel_cache[$value];
        }
        
        if(!ctype_lower($value)) {
            $key = $value;
            $value = preg_replace('/\s+/u', '', ucwords($value));
            $replaced = preg_replace('/(.)(?=[A-Z])/u', '$1'.'_', $value);
            $value = mb_strtolower($replaced, 'UTF-8');
            self::$camel_cache[$key] = $value;
        }
        return $value;
    }
    
    public static function studly($value) 
    {
        if (isset(static::$studly_cache[$value])) {
            return static::$studly_cache[$value];
        }
        $studly = ucwords(preg_replace('/[^a-zA-Z0-9]+/', ' ', $value));
        return static::$studly_cache[$value] = str_replace(' ', '', $studly);
    }
    
    
    
}