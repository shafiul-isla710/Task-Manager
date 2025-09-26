<?php

namespace App\Http\Controllers\Api\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Mail\Mailer;
use Illuminate\Http\Request;
use App\Models\PasswordResetOtp;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\API\v1\Auth\ResetPasswordRequest;
use App\Http\Requests\API\v1\Auth\ForgotPasswordRequest;
use App\Http\Requests\API\v1\Auth\ForgotPasswordVerifyOtpRequest;

class ForgotPasswordController extends Controller
{
    
   public function sendOtp(ForgotPasswordRequest $request)
   {
        try{
                $otp = rand(100000, 999999);
                PasswordResetOtp::updateOrCreate(
                    [
                        'email'=>$request->email,
                    ],
                    [
                        'otp'=>$otp,
                        'expires_at'=>Carbon::now()->addMinutes(10)
                    ]
                );

                Mail::raw("Your Password Reset OTP is $otp and it will Expire in 10 minutes",function($message) use($request){
                    $message->to($request->email);
                    $message->subject('Your OTP for password reset');
                });
                return $this->success($otp,'OTP sent to your email');
        }
        catch(\Exception $e){
            Log::error('Error in sending OTP: '.$e->getMessage());
            return $this->error([$e->getMessage()],500);
        }
   }
   public function verifyOtp(ForgotPasswordVerifyOtpRequest $request)
   {
        try{
            $record = PasswordResetOtp::whereEmail($request->email)
                    ->whereOtp($request->otp)
                    ->first();
            if(!$record){
                return $this->error(['Invalid OTP']);
            }
            else if(Carbon::now()->isAfter($record['expires_at'])){
                return $this->error(['OTP Expired, Please request a new one']);
            }
            else{
                return $this->success([],'OTP verified, you can now reset your password');
            }
        }
        catch(\Exception $e){
            Log::error('Error in verifying OTP: '.$e->getMessage());
            return $this->error([$e->getMessage()],500);
        }
   }

   public function resetPassword(ResetPasswordRequest $request)
   {
        try{
            $record = PasswordResetOtp::whereEmail($request->email)
                    ->whereOtp($request->otp)
                    ->first();
            if(!$record){
                return $this->error(['Invalid OTP']);
            }
            else if(Carbon::now()->isAfter($record['expires_at'])){
                return $this->error(['OTP Expired, Please request a new one']);
            }
            else{
                $user = User::whereEmail($request->email)->first();
                $user['password'] = $request->password;
                $user->save();
                $record->delete();
                return $this->success([],'Password reset successfully');
            }
        }
        catch(\Exception $e){
            Log::error('Error in resetting password: '.$e->getMessage());
            return $this->error([$e->getMessage()],500);
        }
   }


}
