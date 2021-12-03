<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserController extends Controller
{
    public function register(Request $request){
        date_default_timezone_set('Asia/Manila');
        $userData = $request->input();
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['message' =>'Email already taken']);
        } else {
            $user = new User;
          
            $user->email = $userData['email'];
            $user->password = bcrypt($userData['password']);
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->remember_token = Str::random(60);
            $user->lock_count = 0;
            $user->save();
            return response()->json(['message' =>'User successfully registered']);
        }
     
    }

    public function login(Request $request){
        date_default_timezone_set('Asia/Manila');
        $userData = $request->input();
        $userLoginData = array(
            'email' =>$userData['email'],
            'password' =>$userData['password'],
        );
        if(Auth::attempt($userLoginData)){
            $date = date('Y-m-d H:i:s');
            if($date > Auth::user()->lock_time){
                DB::table('users')
                ->where('id', Auth::user()->id)
                ->update(['lock_time' => null,'lock_count' => 0]);
                return response()->json(['access_token' =>Auth::user()->remember_token]);
            }else{
                return response()->json(['message' =>'Sorry but your Account has been lock Pleas wait 5 mins']);
            }
        }else{
            $Data = DB::table('users')->where('email',$userData['email'])->first();
            $lockCount = $Data->lock_count;
            $lockCount = $lockCount + 1;
            $time = Carbon::parse(date('Y-m-d H:i:s'));
            $timeLock = $time->addMinutes(5);
            if($lockCount < 5){
                $query = ['lock_count' => $lockCount];
            }else{
                $query = ['lock_time' => $timeLock,'lock_count' => $lockCount];
            }
            DB::table('users')
            ->where('id', $Data->id)
            ->update($query);
            if($lockCount >= 5){
                return response()->json(['message' =>'Sorry but your Account has been lock for 5 mins']);
            }else{
                return response()->json(['message' =>'Invalid credentials']);
            }
        }
    }
    
}
