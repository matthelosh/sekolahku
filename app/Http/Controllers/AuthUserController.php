<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Mews\Captcha\Facades\Captcha;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class AuthUserController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth.login');
    }
    
    public function authenticate(Request $request)
    {
            $request->validate(
                [
                    'username' => 'required',
                    'password' => 'required',
                    'captcha' => 'required|captcha'
                ],
                [
                    'username.required' => 'Username Harus diisi',
                    'password.required' => 'Password harus diisi',
                    'captcha.required' => 'Captcha harus dijawab',
                    'captcha.captcha' => 'Jawaban captcha salah. Coba lagi!'
                ]
            );
        try {
            $remember = $request->remember_me;
            // dd($request);
            $isUser = Auth::attempt(['username' => $request->username]);
            if (!$isUser) {
                return back()->withErrors(['username' => 'Username belum terdaftar. Silahkan mendaftar atau hubungi admin.']);
            }
            $login = Auth::attempt(['username' => $request->username, 'password' => $request->password], $remember);
            if ( !$login ) {
                return back()->withErrors(['password' => 'Cek lagi password Anda. Klik lupa password jika ingin mereset.']);
            } else {
                $user = Auth::user();
                if ( $user->email_verified_at ) {
                    return redirect('/');
                } else {
                    return view('auth.verify-email', ['user' => $user]);
                }
            }

            // Check if user exist
            

        } catch ( \Exception $e ) 
        {
            if(preg_match("/Connection refused/i", $e->getMessage())) {
                return back()->withErrors(['db_error' => 'Database tidak tersambung. Hubungi Admin.']);
                // dd($e->getMessage());
            }
        }
    }

    public function register()
    {
        return view('auth.register');
    }

    public function regUser(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|unique:users',
                'username' => 'required|unique:users',
                'password' => 'required',
                'captcha' => 'required|captcha'
            ],
            [
                'email.required' => 'Email harus diisi',
                'email.email' => 'Format email harus sesuai [xxxxx@xxx.xxx]',
                'email.unique' => 'Alamat Email sudah digunakan, ganti yang lain',
                'username.required' => 'Username Harus diisi',
                'password.required' => 'Password harus diisi',
                'username.unique' => 'Username sudah digunakan. Ganti yang lain',
                'captcha.required' => 'Captcha harus dijawab',
                'captcha.captcha' => 'Jawaban captcha salah. Coba lagi!'
            ]
        );

        $user = User::create([
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);

        // MEngirimkan email verifikasi
        event(new Registered($user));

        return redirect()->route('login')->with('status', 'Registrasi berhasil. Silahkan Login dengan username dan password Anda. Cek kotak masuk di email untuk verifikasi.');

    }

    public function forgotPassword(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email'
            ], 
            [
                'email.required' => 'Email harus diisi', 
                'email.email' => 'Format email salah'
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );
        // dd($status);
        return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
    
                $user->setRememberToken(Str::random(60));
    
                event(new PasswordReset($user));
            }
        );
    
        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

}
