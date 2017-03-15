<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\cURL;

class ApiTestController extends Controller
{
    public function __construct()
    {
        //
    }
    
    public function test()
    {
        /**
         * ベース
         */
        $ip       = '127.0.0.1:8000';
//         $version  = 'v1';
//         $resource = 'order';
        $resource = 'user';
//         $crud     = 'get';

        $url = "http://{$ip}/{$resource}";

        $param = [
            //
        ];

        $header = [
//             'Content-type: application/json',
//             'Content-Type: application/x-www-form-urlencoded',
//             'Access-Control-Allow-Methods',
//             "Authorization: Bearer {$token}",
        ];

        $ch = new cURL();
        $ch->init();
        $ch->setUrl($url);
        $ch->setUserAgent('Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1');
        $ch->setMethod('GET');
        $ch->setSslVerifypeer(false);
//         $ch->setUserPwd($this->authId, $this->authPass);
        
        $ch->setParameterFromArray($param);
        $ch->setHeader($header);
        
//         $ch->setIsBuildQuery(false);
//         $ch->setIsJson(true);
        
        $response = $ch->exec();
//         echo $response;exit;
        dd( $response );
//         dd( unserialize($response) );

//         \Storage::disk('local')->put('json/oanda.json', $response);

//         dd( $ch->getInfo() );

//         dd( $ch->getErrorMessage() );

        $ch->close();

        $result = json_decode($response);
        dd( $result );
    }
}
