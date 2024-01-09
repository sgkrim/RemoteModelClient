<?php

namespace Sgkrim37\RemoteModelClient\Models;

use Sgkrim37\RemoteModelClient\Helper;
use Sgkrim37\RemoteModelClient\Relations\HasMany;
use Sgkrim37\RemoteModelClient\Relations\HasOne;

class RemoteModel
{
    protected $table = null;
    protected array $fillable = [];
    protected array $casts = [];

    protected array $attributes = [];

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

    function __get(string $name)
    {
        if(method_exists($this, $name)){
            if(
                $this->{$name}() instanceof HasOne
                || ($this->{$name}()) instanceof HasMany
            ){
                return $this->{$name}();
            }
        }

        return $this->attributes[$name]??null;
    }

    function hasOne($class, $remote_field = 'id', $local_field = 'id'): HasOne
    {
        return new HasOne($class, $remote_field, $local_field, $this);
    }

    function hasMany($class, $remote_field = 'id', $local_field = 'id'): HasOne
    {
        return new HasOne($class, $remote_field, $local_field, $this);
    }

}