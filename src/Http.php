<?php

namespace Sgkrim37\RemouteModelClient;

class Http
{

    protected $response = '';

    private function _query($url, $type = 'get', $data = [], $headers = []): string
    {



        return '';
    }

    function get($url, $query_array = [], $headers = []): Response
    {
        return new Response($this->_query($url, 'get', $query_array, $headers));
    }

    function post($url, $data = [], $headers = []): Response
    {
        return new Response($this->_query($url, 'post', $data, $headers));
    }



}