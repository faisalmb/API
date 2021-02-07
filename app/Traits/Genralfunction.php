<?php
namespace App\Traits;
use App\Model\user;
use stdClass;
use App\Model\branch;
use App\Model\company;
use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Str;
// use Symfony\Component\Console\Input\Input;


trait Genralfunction {


  // generate id
    public function generateId()
    {
      return Uuid::generate()->string;
    }

    
    // generate otp number
    public function generateNumericOTP($n) {
    
        // Take a generator string which consist of
        // all numeric digits
        $generator = "1357902468";

        // Iterate for n-times and pick a single character
        // from generator and append it to $result

        // Login for generating a random character from generator
        //     ---generate a random number
        //     ---take modulus of same with length of generator (say i)
        //     ---append the character at place (i) from generator to result

        $result = "";

        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, (rand()%(strlen($generator))), 1);
        }

        // Return result
        return $result;
      }

      // check headers
      public function checkheaders($request){
        $Content_Type = $request->headers->get('Content-Type');
        $Authorization = $request->headers->get('Authorization');

        if (0 !== strpos($Content_Type, 'application/json') || empty($Authorization)){
          if (0 !== strpos($Content_Type, 'application/json'))
          {
               return 4011;// response()->json($msg, 401);
          }

          if (empty($Authorization))
          {
               return 4012;// response()->json($msg, 401);
          }

        }else {
         return 200;//
        }
      }

      // check headers company Id
      public function checkHeadersCompanyId($request){
        $companyId = $request->headers->get('CompanyId');
        if (empty($companyId)){
          $result = (object) array(
            'status'=>401,
            'content'=>'CompanyId is empty'
          );
          return $result;//
        }else {
          $company = company::select('*')
          ->where('id', $companyId)
          ->first();
          if ($company) {
            $result = (object) array(
              'status'=>200,
              'content'=>$companyId
            );
            return $result;//
          }else {
            $result = (object) array(
              'status'=>401,
              'content'=>'CompanyId does not exist Or incorrect'
            );
            return $result;//
          } 
        }
      }

        // check headers branch Id
        public function haveBrach($request){
          $branchId = $request->headers->get('branchId');
          if (empty($branchId)){
            $result = (object) array(
              'status'=>401,
              'content'=>'branchId is empty'
            );
            return $result;//
          }else {
            $branch = branch::select('*')
            ->where('id', $branchId)
            ->first();
            if ($branch) {
              $result = (object) array(
                'status'=>200,
                'content'=>$branchId
              );
              return $result;//
            }else {
              $result = (object) array(
                'status'=>401,
                'content'=>'branchId does not exist Or incorrect'
              );
              return $result;//
            } 
          }
        }


          // check headers  Ids
          public function haveId($request,$id){
          $Id = $request->headers->get($id);

              $result = (object) array(
                'status'=>200,
                'content'=>$Id
              );
              return $result;//
          
          
        }


      // return token
      public function bearerToken($request)
      {
         $header = $request->headers->get('Authorization');
         if (Str::startsWith($header, "Bearer ")) {
                  return Str::substr($header, 7);
         }
      }

      // check token if exists and return info
      public function checktoken($request)
      {
        $checktoken = $this-> bearerToken($request);
        $user = user::where('token', $checktoken)
        ->first();
        return $user;
      }

      

      // check reset token if exists and return info
      public function checkResetToken($request)
      {
        $checktoken = $this-> bearerToken($request);
        $user = user::where('recover', $checktoken)
        ->first();
        return $user;
      }

    //  function for return time
      public function timenow()
      {
        $mytime = Carbon::now();
        return $mytime->toDateTimeString();
      }


        // check header
      public function checkError($check)
      {
        $msg = '';
        switch ($check) {
          case '4011':
             $msg = 'Content-Type require application/json';
            break;
          case '4012':
             $msg = 'token is empty' ;
            break;

          default:
            $msg = 'internal server error' ;
            break;
        }
        return $this->generalResponse(false,401,$msg, null,null);
      }

   


      // send sms to sys user
      public function sendUserSms($phone,$message)
      {

              $sender = 'sender';
              $username = 'username';
              $password = 'password';
              $sendmessage = 'sendmessage';
              $message =	$message;
              $number  = $phone ;
              $url = 'http://sms2.nilogy.com/app/gateway/gateway.php?sendmessage='.$sendmessage.'&username='.$username.'&password='.$password.'&text='.urlencode($message).'&numbers='.urlencode($number).'&sender='.$sender.'';
              $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL, $url);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              $data = curl_exec($ch);
              $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
              $datainfosende=json_decode($data,true);
              $response = '';
              if ($httpcode != 0) {
                if($datainfosende['success'] == 0){
                  $response = false ;
                }else{
                  $response = true;
                }

              }else {
                $response = false ;
              }

             return $response;
                
              curl_close($ch);
      }


      /*

      Coding Standards :

      message : String or "",

      Error : Array or [] .

      data : object or array of object  or {},

      status : false or true

      code : one of http codes like (401,200,422 ...)

      */

    function generalResponse($status, $code, $message, $errors = null, $data = null)
    {
        $data = is_null($data) ? new stdClass() : $data;
        return response()->json(['status' => $status, 'code' => $code, 'message' => $message, 'errors' => $errors, 'data' => $data], $code);
    }


 


}
