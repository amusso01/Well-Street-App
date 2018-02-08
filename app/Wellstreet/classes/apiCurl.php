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
    public $key;
    public $url;
    public $parameter;

    function __construct($key, $url, $parameter)
    {
        $this->key = $key;
        $this->url = $url;
        $this->parameter = $parameter;
    }

    public function addressResult()
    {
        $my_curl = curl_init();
        curl_setopt($my_curl, CURLOPT_URL, $this->url . '' . $this->parameter);
        curl_setopt($my_curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($my_curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($my_curl, CURLOPT_USERPWD, 'api-key:' . $this->key);
        $res = curl_exec($my_curl);
        if (!curl_errno($my_curl)) {
            switch ($http_code = curl_getinfo($my_curl, CURLINFO_HTTP_CODE)) {
                case 200:  # OK
                    $res=json_decode($res);
                    return $res;
                    break;
                case 404:
                    return 'No addresses could be found for this postcode';
                    break;
                case 400:
                    return 'Your postcode is not valid';
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
        }
        curl_close($my_curl);
        return $res;
    }
}