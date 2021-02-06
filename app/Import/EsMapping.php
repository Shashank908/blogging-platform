<?php

namespace App\Import;

use DB;
use Config;
use Exception;

class EsMapping
{
    public function handle()
    {
        try {
            $ch = curl_init();
            $data = Config::get('blog.elsatic_search.index_data');
        
            if (FALSE === $ch)
                throw new Exception('failed to initialize');
            $url = Config::get('blog.elsatic_search.es_url').'/'.
                    Config::get('blog.elsatic_search.default_index').'?pretty';
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                                    'Content-Type: application/json'
                                                    ));
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_PROXY, '');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        
        
            $request=  curl_getinfo($ch);
            var_dump($request);
        
        
            $content = curl_exec($ch);
        
        
            if (FALSE === $content)
                throw new Exception(curl_error($ch), curl_errno($ch));
        
        
        
        } catch(Exception $e) {
            dump($e->getMessage());
            trigger_error(sprintf(
                'Curl failed with error #%d: %s',
                $e->getCode(), $e->getMessage()),E_USER_ERROR);
        
        }
    }
}