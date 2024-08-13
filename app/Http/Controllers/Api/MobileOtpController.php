<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MobileOtpController extends Controller
{
    public function getNumber(Request $request){
        $numbers = 9313434881;
        $message = $otp." Thank you to connect Bhaskar Group. -Bhaskar Group";

        if(strlen($numbers)>10){

        }else{
          $numbers = "91".$numbers;
        }
        $d = date("Y-m-d H:i:s");
        $url = "https://api.infobip.com/sms/1/text/query?username=missedcall&password=missedcall@123&to=".urlencode($numbers)."&text=".urlencode($message)."&from=BHASKR&indiaDltPrincipalEntityId=1101693520000011534&indiaDltContentTemplateId=1107161141043932938";
    
        $postpara ="";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url );
        curl_setopt($ch, CURLOPT_POST, 1 );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postpara);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $postResult = curl_exec($ch);
        curl_close($ch);
      
    }
}
