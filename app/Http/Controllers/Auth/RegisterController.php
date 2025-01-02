<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile' => ['required', 'string', 'size:11', 'regex:/^\d{11}$/'],
            'sex' => ['required', 'in:male,female,other'],
            'birthdate' => ['required', 'date', 'before:today'],
            'role' => ['required', 'integer', 'in:2,3'], // 2 = Artist, 3 = Customer
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[0-9]/',        // Must contain at least one number
                'regex:/[@$!%*#?&]/',   // Must contain at least one special character
                'regex:/[A-Z]/',        // Must contain at least one uppercase letter
            ],
        ], [
            'password.regex' => 'The password must include at least one uppercase letter, one special character, and one number.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'mobile' => $data['mobile'],
            'sex' => $data['sex'],
            'birthdate' => $data['birthdate'],
            'role' => $data['role'], // Stores either 2 (Artist) or 3 (Customer)
        ]);
    }

    protected function registered(Request $request, $user)
    {
        if ($user->role === 2) {
            $artist = Artist::where('user_id', $request->user()->id)->first();
            if (isset($artist->id) && $artist->verification_status !== 'approved') {
                return redirect()->to('artist/artist/fill-up');
            }

            if (!isset($artist->id)) {
                return redirect()->to('artist/artist/fill-up');
            }
        }
    }
}
