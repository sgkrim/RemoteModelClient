<?php

namespace Sgkrim37\RemouteModelClient\Models;

use Sgkrim37\RemouteModelClient\Helper;

class RemoteModel
{
    protected $table = null;
    protected array $fillable = [];
    protected array $casts = [];

    protected static array $build = [];


    function __construct(){

        $this->table = Helper::getTableName(get_class($this));

    }

    static function __callStatic(string $name, array $arguments)
    {

        if(in_array($name, ['all', 'get', 'first'])){
            return self::$build;
        }

        self::$build[] = [
            'name' => $name,
            'args' => $arguments,
        ];

        return new self;
    }

    function __call(string $name, array $arguments){

        if(in_array($name, ['all', 'get', 'first'])){
            return self::$build;
        }

        self::$build[] = [
            'name' => $name,
            'args' => $arguments,
        ];

        return $this;
    }

}