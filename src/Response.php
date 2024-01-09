<?php

namespace Sgkrim37\RemouteModelClient;

class Response
{

    protected string $data = '';

    function __construct(string $data){
        $this->data = $data;
    }

    function string(): string
    {
        return $this->data;
    }

    function array(): array|null {
        return json_decode($this->data, true);
    }

    function object(): object|null {
        return json_decode($this->data);
    }

}