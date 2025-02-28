<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Invite;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Lang;
use Carbon\Carbon;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($request->missing('token')) 
        {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

        }else{
            $invite = Invite::where('token', $request->token)->first();
            $user = User::create([
                'name' => $request->name,
                'email' => $invite->email,
                'password' => Hash::make($request->password),
                'locale' => $invite->locale,
                'email_verified_at' => Carbon::now()
            ]);

            $user->assignRole($invite->role);
            $invite->delete();
        }
        
        event(new Registered($user));
        Auth::login($user);
        return to_route('dashboard');
    }

    public function registration($token)
    {
        try {
            Invite::where('token', $token)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return redirect()->route('login')->with('error', Lang::get('Wrong invitation token! Please check'));
        }

        $invite = Invite::where('token', $token)->first();
        return Inertia::render('auth/RegisterInvite', ['invite' => $invite, 'token' => $token]);
    }
}
