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

class FacebookController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();

            // Check Users Email If Already There
            $is_user = UserCustomModel::where('email', $user->getEmail())->first();
            if (!$is_user) {

                return redirect()->route('login')->with('msg', 'Usuário não encontrado!');          


            } else {
                $saveUser = UserCustomModel::where('email',  $user->getEmail())->update([
                    'facebook_id' => $user->getId(),
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
