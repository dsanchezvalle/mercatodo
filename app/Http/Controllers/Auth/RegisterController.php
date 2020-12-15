<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make(
            $data,
            [
            'name' => ['required', 'string', 'min:2', 'max:50', 'regex:/^[a-zA-Z0-9áéíóúüñÑ\s\.]+$/'],
            'surname' => ['required', 'string', 'min:2', 'max:50', 'regex:/^[a-zA-Z0-9áéíóúüñÑ\s\.]+$/'],
            'document_type' => ['required', 'string', 'max:2'],
            'document_number' => ['required', 'string', 'max:50', 'alpha_num'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'phone_number' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data): User
    {
        $data['role_id'] = 3;

        return User::create(
            [
            'name' => $data['name'],
            'surname' => $data['surname'],
            'document_type' => $data['document_type'],
            'document_number' => $data['document_number'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'role_id' => $data['role_id'],
            'password' => Hash::make($data['password']),
            ]
        );
    }
}
