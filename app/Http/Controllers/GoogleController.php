<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function index()
    {
        return view('login.index', [
            'title'=>'Login',
            'active'=>'login'
        ]);
    }

    public function redirect()
    {
        return Socialite::driver('google')->redirect();  
    }
    
    public function callback()
    {
        $googleUser=Socialite::driver('google')->stateless()->user();
        $user = User::where(['email'=> $googleUser->email])->first();
        if(!$user){
            $user = User::create([
                'name' => $googleUser->name,
                'email'=> $googleUser->email,
                'username' => $googleUser->name,
                'password' => bcrypt('default_password')
            ]);
        }
        Auth::login($user);
        return redirect('/');
    }
    
}
