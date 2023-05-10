<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function  authlogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:2',
        ]);
        $email=$request->email;
        $password=$request->password;
        $user = \DB::table('users')->where('email', $email)->first();
        if(!empty($user))
        {
            if($email==$user->email && Hash::check($password,$user->password))
                dd("sucees");
        }
        else
        {
            $message="Invalid Email & Password";
            return redirect()->back()->with('message',$message);

        }
    }
    public function  forgetpassword(Request $request)
    {
        dd($request->toArray());
    }
}
