<?php

namespace Sgkrim37\RemoteModelClient;

use Doctrine\Inflector\InflectorFactory;
use Doctrine\Inflector\Language;

class Helper
{

    protected static array $snakeCache = [];


    public static function strContains($haystack, $needles, $ignoreCase = false): bool
    {
        if ($ignoreCase) {
            $haystack = mb_strtolower($haystack);
        }

        if (! is_iterable($needles)) {
            $needles = (array) $needles;
        }

        foreach ($needles as $needle) {
            if ($ignoreCase) {
                $needle = mb_strtolower($needle);
            }

            if ($needle !== '' && str_contains($haystack, $needle)) {
                return true;
            }
        }

        return false;
    }

    static function strSnake($value, $delimiter = '_'){
        $key = $value;

        if (isset(static::$snakeCache[$key][$delimiter])) {
            return static::$snakeCache[$key][$delimiter];
        }

        if (! ctype_lower($value)) {
            $value = preg_replace('/\s+/u', '', ucwords($value));

            $value = static::lower(preg_replace('/(.)(?=[A-Z])/u', '$1'.$delimiter, $value));
        }

        return static::$snakeCache[$key][$delimiter] = $value;
    }

    public static function lower($value): string
    {
        return mb_strtolower($value, 'UTF-8');
    }

    public static function plural($value): string
    {
        $inflector = InflectorFactory::createForLanguage(Language::ENGLISH)->build();
        return $inflector->pluralize($value);
    }

    public static function getTableName($class_name): string
    {
        $class_name = str_replace('\\', '/', $class_name);
        if(self::strContains($class_name, '/')){
            $class_name = explode('/', $class_name);
            $class_name = end($class_name);
        }
        return self::plural(self::strSnake($class_name));
    }

}