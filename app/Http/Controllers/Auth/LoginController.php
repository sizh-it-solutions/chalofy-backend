<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\GeneralSetting;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(Request $request)
    {
        $settings = GeneralSetting::whereIn('meta_key', [
        'general_captcha',
        'site_key',
        'private_key'
    ])->pluck('meta_value', 'meta_key');

    $general_captcha = $settings['general_captcha'] ?? 'no';
    $site_key        = $settings['site_key'] ?? null;
    $private_key     = $settings['private_key'] ?? null;
       if($general_captcha=='yes')
       
     {   $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required',
        ]);

        $recaptchaResponse = $request->input('g-recaptcha-response');
        $response = Http::post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' =>  $private_key,
            'response' => $recaptchaResponse,
            'remoteip' => $request->ip()
        ]);

        if (!$response->json()['success']) {
            return redirect()->back()
                ->withErrors(['g-recaptcha-response' => 'reCAPTCHA verification failed.'])
                ->withInput();
        }}

       
    }

    public function showLoginForm()
{
    $settings = Cache::remember('general_login_settings', 60, function () {
        return GeneralSetting::whereIn('meta_key', [
            'general_name',
            'general_description',
            'general_logo',
            'general_favicon',
            'general_loginBackgroud',
            'general_captcha',
            'site_key',
            'private_key',
        ])->pluck('meta_value', 'meta_key');
    });

    return view('auth.login', [
        'logoUrl' => "/storage/" . ($settings['general_logo'] ?? 'default-logo.png'),
        'siteName' => $settings['general_name'] ?? 'Unibooker',
        'tagLine' => $settings['general_description'] ?? '',
        'faviconUrl' => "/storage/" . ($settings['general_favicon'] ?? 'favicon.ico'),
        'loginBackgroud' => "/storage/" . ($settings['general_loginBackgroud'] ?? 'default-bg.jpg'),
        'general_captcha' => $settings['general_captcha'] ?? 'no',
        'site_key' => $settings['site_key'] ?? '',
        'private_key' => $settings['private_key'] ?? '',
    ]);
}

}
