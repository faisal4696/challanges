<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use Carbon\Carbon;

class UserController extends Controller
{
    public function signup(Request $request)
    {
        $checkemail = User::where('email',$request->email)->first();
        if($checkemail == null){
            $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'password' => 'required',
            ]);

            if($validator->fails()){
                return response()->json(['status'=>false,'response'=>$validator->errors()->first()]);
            }
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);

            $responseArray = [];
            $responseArray['id'] = $user->id;
            $responseArray['name'] = $user->name;
            $responseArray['token'] = $user->createToken('challanges')->accessToken;
            return response()->json(['status'=>true,'response'=>$responseArray]);
        }else{
            return response()->json(['status'=>false,'response'=>'Email Already Exist']);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'response'=>$validator->errors()]);
        }else{
            if(Auth::attempt(['email'=>$request->email , 'password'=>$request->password])){
                $user = Auth::user();
                if($request->device_id != null){
                    $user->device_id = $request->device_id;
                    $user->save();
                }
                $responseArray = [];
                $responseArray['id'] = $user->id;
                $responseArray['name'] = $user->name;
                $responseArray['token'] = $user->createToken('challanges')->accessToken;
                return response()->json(['status'=>true,'response'=>$responseArray]);
    
            }else{
                return response()->json(['status'=>false,'response'=>'Email or Password is wrong']);
            }
        }
    }

    public function userdetails()
    {
        $users = User::all();
        return response()->json(['status'=>true,'response'=>$users]);
    }

    public function userstatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['status'=>false,'response'=>$validator->errors()]);
        }else{
            $user = User::where('id',Auth::user()->id)->first();
            if($request->status == 'true'){
                $user->status = 'online';
            }else{
                $user->status = 'offline';
                $user->last_seen = Carbon::now();
            }
            if($user->save()){
                return response()->json(['status'=>true,'reponse'=>'user status is '.$user->status]);
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['status'=>true,'response'=>'user logout']);
    }
}
