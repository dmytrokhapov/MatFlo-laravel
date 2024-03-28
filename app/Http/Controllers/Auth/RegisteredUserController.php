<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $id = 'NULL';
        Validator::extend('unique_email', function ($attribute, $value, $parameters) {
            //dd($value, $attribute, $parameters);
            $user = User::where('email', $value)->where('id', '!=', $parameters[0])->whereNull('deleted_at')->count();
            if ($user != 0) {
                return false;
            } else {
                return true;
            }
        }, 'Email id is already exists.');

        $request->validate([
            'role' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique_email:'.$id],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // $request->merge(['wallet' => 0]);


        // dd($request->all());
        $user = User::create([
            'role' => $request->role,
            'user_name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}