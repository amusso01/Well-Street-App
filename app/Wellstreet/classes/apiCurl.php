<?php
/**
 * Created by PhpStorm.
 * User: desktop
 * Date: 2/2/2018
 * Time: 4:08 PM
 */

namespace Wellstreet\classes;


class apiCurl
{
    public $key;//service api key
    public $url;//url to call
    public $parameter;//parameter to pass to the service

    function __construct($key, $url, $parameter)
    {
        $this->key = $key;
        $this->url = $url;
        $this->parameter = $parameter;
    }

//    call the web service and return an understandable response
    public function addressResult()
    {
        $my_curl = curl_init();
        curl_setopt($my_curl, CURLOPT_URL, $this->url . '' .urlencode( $this->parameter));
        curl_setopt($my_curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($my_curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($my_curl, CURLOPT_USERPWD, 'api-key:' . $this->key);
        $res = curl_exec($my_curl);
        if ($res==false){
            return curl_error($my_curl);
        }
        if (!curl_errno($my_curl)) {
            switch ($http_code = curl_getinfo($my_curl, CURLINFO_HTTP_CODE)) {
                case 200:  // OK
                    $res=json_decode($res);
                    return $res;
                    break;
                case 404:
                    return 'No addresses could be found for this postcode';
                    break;
                case 400:
                    return 'Your postcode was not valid. Please enter a new postcode';
                    break;
                case 401:
                    return 'Api key is not valid or expired';
                    break;
                case 429:
                    return 'You have made more requests than your allowed limit max 50 a day';
                    break;
                default:
                    echo 'Unexpected HTTP code: ', $http_code, "\n";
            }
        }else{
            return curl_errno($my_curl);
        }
        curl_close($my_curl);
        return $res;
    }
}