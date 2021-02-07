<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class User extends Controller
{
   
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    // // Get user in my company
    //      public function GetUserByCompanyRequest(Request $request,$page)
    //      {
    //         $info = $this->checktoken($request);
    //         $companyId = $info->com_id; // $request->input('com_id');
    //         return $this->getUserByCompanyId($companyId,$page);

    //      }
          // // Get user in my store
          // public function GetUserByStoreRequest(Request $request,$page)
          // {
          //   $info = $this->checktoken($request);
          //   $companyId = $info->com_id; // $request->input('com_id');
          //   $userId = $info->id;
          //   return $this->getUserByStoreId($companyId,$userId,$page);
          // }

         // Get user  by id
          public function GetUserByIDRequest(Request $request)
          {
            // if ($this->checkHeadersUserId($request)->status == 200) {
              $id = $request->id;
              return $this->getuserByid($id);

            // } else {
            //   return response()->json($this->checkHeadersUserId($request)->content, $this->checkHeadersUserId($request)->status);
            // }

            
          }

         // Get user  by name or phone  paging
          public function GetUserbyinfoRequest(Request $request)
            {
                  $this->validate($request, [
                    'search' => 'required'
                    ]);

                  $page = $request->page;
                  $search =  $request->input('search');
                  return $this->getuserInfo($search,$page);
            } 

         // login 
          public function loginRequest(Request $request)
          {
              $this->validate($request, [
                'phone' => 'required|min:4',
                'password' => 'required|min:8|max:20'
                // 'location' => 'required|alpha'
                ]);
              $phone =  $request->input('phone');
              $password = hash('sha256',$request->input('password'));
              return $this->login($phone,$password);
          }


          // login 
          public function registrationRequest(Request $request)
          {
              $this->validate($request, [
                'phone' => 'required|max:9',
                'fullname' => 'required|max:30',
                'cuntry_id' => 'required|max:30',
                ]);
              $phone =  $request->input('phone');
              $fullname =$request->input('fullname');
              $email =$request->input('email');
              $cuntryId =$request->input('cuntry_id');
              return $this->addUser($phone,$email,$fullname,$cuntryId);
          }


          public function resitPasswordRequest(Request $request)
          {
            $info = $this->checkResetToken($request);
            $this->validate($request, [
              'phone' => 'required',
              'recoverCode' => 'required'
              ]);
            $phone =  $request->input('phone');
            $otpcode = $request->input('recoverCode');
            return $this->resetPasswod($phone,$otpcode,$info->id);
          }




        // update user by user
          public function updateuserRequest(Request $request)
          {
            $info = $this->checktoken($request);
            $this->validate($request, [
              'phone' => 'required|min:4|max:9',
              'email' => 'string|nullable',
              'fullname' => 'required|string'
              ]);
            
            $phone = $request->input('phone');
            $email = $request->input('email');
            $fullname =  $request->input('fullname');
            return $this->upadteRaote($info,$phone,$email,$fullname);
          }

        // update user by admin
          public function activeuserRequest(Request $request)
          {
            $info = $this->checktoken($request);
            $this->validate($request, [
              'id' => 'required|string',
              'IsActive' => 'required|boolean',
              'IsSuperAdmin' => 'required|boolean'
              ]);
            $userId = $request->input('id');
            $IsActive = $request->input('IsActive');
            $IsSuperAdmin = $request->input('IsSuperAdmin');
              return $this->activateUser($userId,$IsActive,$IsSuperAdmin);
          }

        // update user by user
          public function updatePasswordRequest(Request $request)
          {
            $info = $this->checktoken($request);
            $this->validate($request, [
              'oldPassword' => 'required|min:8|max:20',
              'newPassword' => 'required|min:8|max:20',
              'confirmPassword' => 'required|min:8|max:20'
              ]);
            $oldPassword = hash('sha256',strval($request->input('oldPassword')));
            $newconfirmPassword = hash('sha256',strval($request->input('newPassword')));
            $userId = $info->id;
            $newPassword = strval($request->input('newPassword'));
            $confirmPassword = strval($request->input('confirmPassword'));
            if ($newPassword == $confirmPassword && $oldPassword == $info->password) {
              return $this->updatePasswod($userId,$newconfirmPassword);

            } else {
              if ($newPassword != $confirmPassword) {
                $msg = 'confirm password incorrect' ;
                return $this->generalResponse(false,400,$msg, null,null);
              } else if ($oldPassword != $info->password) {
                $msg = 'old password incorrect' ;
                return $this->generalResponse(false,400,$msg, null,null);
              } else {
                $msg = 'Something is wrong' ;
                return $this->generalResponse(false,400,$msg, null,null);
              }
            }
          }

       // generate code for resit password
          public function generateCodeResetRequest(Request $request)
          {
              $phone = $request->phone;
              return $this->genCoderesetPasswod($phone);
          }


          // generate code for change phone
          public function genCodeChanePhoneRequest(Request $request)
          {
              $info = $this->checktoken($request);
              $userId = $info->id;
              $phone = $request->phone;
              return $this->genCodeChanePhone($phone,$userId);
          }


          public function chanePhoneRequest(Request $request)
          {
            $info = $this->checkResetToken($request);
            $this->validate($request, [
              'phone' => 'required',
              'recoverCode' => 'required'
              ]);
            $phone =  $request->input('phone');
            $otpcode = $request->input('recoverCode');
            $userId = $info->id;
            return $this->changePhone($phone,$otpcode,$userId);
          }



}
