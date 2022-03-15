<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserCustomModel;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use AuthenticatesUsers;
use App\User;
use Illuminate\Support\Facades\Hash;

class GoogleController extends Controller
{
    
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            // Check Users Email If Already There
            $is_user = UserCustomModel::where('email', $user->getEmail())->first();
            if(!$is_user){

                return redirect()->route('login')->with('msg', 'Usuário não encontrado!');
                /*
                $saveUser = UserCustomModel::updateOrCreate([
                    'google_id' => $user->getId(),
                ],[
                    'nome' => $user->getName(),
                    'email' => $user->getEmail(),
                    'password' => Hash::make($user->getName().'@'.$user->getId())
                ]);

                */
                
            }else{
                $saveUser = UserCustomModel::where('email',  $user->getEmail())->update([
                    'google_id' => $user->getId(),
                ]);
                $saveUser = UserCustomModel::where('email', $user->getEmail())->first();
            }


            Auth::loginUsingId($saveUser->id);

            return redirect()->route('inicio');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
