<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MobileVerification;
use App\Models\UserEventPersonalData;

class MobileOtpController extends Controller
{
    public function getNumber(Request $request){
        $numbers = $request->mobile_num;
        // $otp = mt_rand(000001, 999999);
        $otp = 123456;
        $message = $otp." Thank you to connect Bhaskar Group. -Bhaskar Group";

        if(strlen($numbers)>10 || strlen($numbers)<10){
          return response()->json([
            'number' => 'invalid',
         ]);

        }else{
          $numbers = "91".$numbers;
          MobileVerification::create([
            'otp'=>$otp,
            'mobile'=>$numbers
          ]);
        }

        $d = date("Y-m-d H:i:s");
        // $url = "https://api.infobip.com/sms/1/text/query?username=missedcall&password=missedcall@123&to=".urlencode($numbers)."&text=".urlencode($message)."&from=BHASKR&indiaDltPrincipalEntityId=1101693520000011534&indiaDltContentTemplateId=1107161141043932938";
    
        // $postpara ="";
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url );
        // curl_setopt($ch, CURLOPT_POST, 1 );
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $postpara);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $postResult = curl_exec($ch);
        // curl_close($ch);

        return response()->json([
          'number' => 'valid',
       ]);
      
    }

    public function otpCheck(Request $request){
       $latestOtp = MobileVerification::where('mobile','91'.$request->mobile_num)->latest()->first();   
       $userdata = UserEventPersonalData::where('mobile_number',$request->mobile_num)->first();  
       if(!$latestOtp){
        return response()->json([
          'number' => 'invalid',
         ]);
       }
       if($latestOtp->otp == $request->otp){
        return response()->json([
          'number' => 'valid',
          'userdata' => $userdata
         ]);
       }
       return response()->json([
        'number' => 'invalid',
       ]);
    }
}
