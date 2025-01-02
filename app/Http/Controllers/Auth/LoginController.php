<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        // if ($user->is_blocked) {
        //     Auth::logout(); // Log the user out
        //     return redirect('/login')->withErrors(['Your account has been blocked.']);
        // }
        if ($user->role === 2) {
            $artist = Artist::where('user_id', $user->id)->first();
            if (!$artist || $artist->verification_status !== 'approved') {
                return redirect()->route('artist.artist.add')->with('error', 'Your account is not verified yet.');
            }
            return redirect()->route('artist.index');
        }
    
        if ($user->role === 3) {
            return redirect()->route('user.index');
        }
    
        if ($user->role === 1) {
            return redirect()->route('admin.index');
        }
    }
}