<?php

namespace Sgkrim37\RemoteModelClient;


class Http
{

    /**
     * @throws \Exception
     */
    private function _query($url, $type = 'get', array $data = [], array $headers = []): string
    {

        $curl = curl_init();

        if(strtolower($type) == 'get'){
            $query = '';

            if(count($data)){
                $query = '?'.http_build_query($data);
            }

            curl_setopt($curl, CURLOPT_URL, $url.$query);
        }
        else{
            curl_setopt($curl, CURLOPT_URL, $url);
            switch (strtolower($type)){

                case 'put':
                    curl_setopt($curl, CURLOPT_PUT, true);
                    break;

                case 'delete':
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                    break;

                default:
                    curl_setopt($curl, CURLOPT_POST, true);
                    break;
            }
            curl_setopt($curl, CURLOPT_POSTFIELDS,
                Helper::strContains(($headers['content-type']??''), 'json')
                    ?
                    json_encode($data)
                    :http_build_query($data));
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        $errors = curl_error($curl);
        curl_close($curl);

        if(!empty($errors)){
            throw new \Exception($errors);
        }

        return $response;
    }

    /**
     * @throws \Exception
     */
    function get($url, $query_array = [], $headers = []): Response
    {
        return new Response($this->_query($url, 'get', $query_array, $headers));
    }

    /**
     * @throws \Exception
     */
    function post($url, $data = [], $headers = []): Response
    {
        return new Response($this->_query($url, 'post', $data, $headers));
    }

    /**
     * @throws \Exception
     */
    function put($url, $data = [], $headers = []): Response
    {
        return new Response($this->_query($url, 'put', $data, $headers));
    }

    /**
     * @throws \Exception
     */
    function delete($url, $data = [], $headers = []): Response
    {
        return new Response($this->_query($url, 'delete', $data, $headers));
    }

}