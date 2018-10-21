<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\Custom;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function reset_password(Request $request)
    {
        $data = ($request->input());
        $url = $url = env('API_URL') . '/v1/reset_password';
        $response = Custom::callPostApi($url, $data);
        if ($response) {

            echo json_encode($response);

        }
    }

    public function sendResetLinkEmail(Request $request)
    {
        $data = [
            'email' => $request['email']
        ];

        $url = env('API_URL') . '/v1/resetPasswordEmail';

        $response = Custom::callPostApi($url, $data);

        if ($response) {

            echo json_encode($response);

        }

    }
}
