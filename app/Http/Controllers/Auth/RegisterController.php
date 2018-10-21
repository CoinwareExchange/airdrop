<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Mail;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function redirectToProvider($provider)
    {
       return Socialite::driver($provider)->with(['auth_type'=>'rerequest'])->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();
        $name = explode(" ", $user->name);
        $data = [
                'first_name' => reset($name),
                'last_name' => end($name),
                'email' => $user->email,
                'provider' => $provider,
                'provider_id' => $user->id,
                'image' => $user->avatar_original,
                'email_verified' => 1
            ];

        $authUser = $this->findOrCreateUser($data);
        if ($authUser)
        {

            auth()->login($authUser);
            return redirect('/dashboard');
        }else
        {
            $this->_status("ERR",'Can not login please try after sometime');
            $this->redirect('/login');
        }
    }

    public function findOrCreateUser($data)
    {
        $authUser = User::where('provider_id','=', $data['provider_id'])
                        ->orWhere('email','=',$data['email'])->first();

        if ($authUser) {
            return $authUser;
        }else
        {
            $user = User::create($data);
            if ($user)
            {
                $email = $user->email;
                $name = $user->first_name;
                $emailData = [
                    "name" => $name
                ];
                Mail::send(['html' => 'mail.welcome_email'], $emailData, function ($message) use ($email, $name) {

                    $message->to($email, $name)
                        ->subject('Welcome to Lala World');
                    $message->from('hello@lalaworld.io', 'Lala World');
                });

                return $user;
            }
        }
    }

    public function email_verification($token)
    {
        $check = User::where('email_verify_token', $token)->first();
        $new_token = str_random(30);
        if (!is_null($check)) {
            $user = User::find($check->id);
            $email = $check->email;
            $firstName = $check->first_name;

            if ($user->email_verified == 1) {
                $title = 'Your email is already verified.';
                return view('pages.verify_email', ['title' => $title]);
            } else {
                $d = [
                    'email_verify_token' => $new_token,
                    'email_verified' => 1
                ];
                $user->update($d);
                $data = [
                    "name" => $firstName,
                ];
                Mail::send(['html' => 'mail.email_verification_confirm'], $data, function ($message) use ($email, $firstName) {
                    $message->to($email, $firstName)
                        ->subject('Email Verification Confirmation');
                    $message->from('hello@lalaworld.io', 'Lala World');
                });
                $title = 'Your email has been successfully verified.';
                return view('pages.verify_email', ['title' => $title]);
                die;
            }
        } else {
            return view('pages.verify_email_404');

        }

    }

    public function reset_password_form($token)
    {
        $check = User::where('forgetpass_token', $token)->first();
        if (!is_null($check)) {
            return view('pages.reset_password_form', ['token' => $token]);
        } else {
            return view('pages.verify_email_404');
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}

