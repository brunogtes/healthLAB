<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use App\Models\UserCustomModel;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class CustomAuthController extends Controller
{

    use AuthenticatesUsers;


    public function index()
    {
        return view('auth.login');
    }


    public function customLogin(Request $request)
    {
        $username = $request->input('email');
        $password = $request->input('password'); // password is form field

        $user = UserCustomModel::where('email', '=', $username)->first();

        if ($user != null) {

            if (Hash::check($password, $user->password)) {

                $user2 = UserCustomModel::where('email', $request->email)->exists();
                //Auth::guard('usuarios')->loginUsingId($user2, true);
                Auth::guard('usuarios')->loginUsingId($user->id);
              
                return redirect("inicio");
            } else {

                return redirect()->route('login')->with('msg', 'Usuario ou senha invalido!');
            }
        }
    }


    public function registration()
    {
        return view('auth.registration');
    }


    public function customRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $check = $this->create($data);

        return redirect("inicio")->withSuccess('You have signed-in');
    }


    public function create(array $data)
    {
        return User::create([
            //'name' => $data['name'],
            'email' => $data['email'],
            //'password' => Hash::make($data['password'])
        ]);
    }


    public function dashboard()
    {
        if (Auth::check()) {
            return view('inicio');
        }

        return redirect("inicio")->withSuccess('You are not allowed to access');
    }


    public function signOut()
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
}
