<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use App\Events\UserWasRegistered;

class AuthController extends Controller
{
    // show login page
    public function index()
    {
        return inertia('Auth/Login');
    }

    //check credentials
    public function login(Request $request){
        request()->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if(\Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            if(auth()->user()->status === 1){
                $request->session()->regenerate();
                return $this->redirectTo();
            }

            return back()->withErrors(['email' => 'You are blocked by Super Admin!']);
        }

        return back()->withErrors(['email' => 'You are providing wrong credentials!']);
    }

    //redirect based on role
    protected function redirectTo()
    {
        if(auth()->user()->isSuperAdmin()){
            return redirect()->route('admin.dashboard');
        }

        if(auth()->user()->isPartner()){
            return redirect()->route('partner.dashboard');
        }

        if(auth()->user()->isSalesHead()){
            return redirect()->route('saleshead.dashboard');
        }

        if(auth()->user()->isSales()){
            return redirect()->route('sales.dashboard');
        }

        if(auth()->user()->isProductionHead()){
            return redirect()->route('prodhead.dashboard');
        }

        if(auth()->user()->isProduction()){
            return redirect()->route('prod.dashboard');
        }

        if(auth()->user()->isClient()){
            return redirect()->route('client.dashboard');
        } 
    }

    //logout
    public function logout(Request $request) {
        \Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    //verify email and role and complete user profile
    public function verifyAndCompleteRegistration(Request $request)
    {
        //check if user has email
        $user = User::whereEmail(Crypt::decryptString($request->email))->first();

        if($user){

            $password = User::whereEmail(Crypt::decryptString($request->email))->whereNotNull('password')->first();

            if($password){
                return redirect()->route('auth.login')->withError('Profile already completed.');
            }

            return inertia('Auth/Complete_Profile',[
                'user' => $user
            ]);
        }

        return back()->withError('User not found!');
    }

    //post complete profile for user
    public function makeProfileComplete(Request $request)
    {
        request()->validate([
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|same:password'
        ]);

        //check if user exists
        $user = User::whereEmail($request->email)->first();
        if($user){
            $user->password = $request->password;
            $user->save();

            event(new UserWasRegistered($user));

            return redirect()->route('auth.login')->withSuccess('Profile Completed! Please login with your credentials');
        }

        return redirect()->route('auth.login')->withError('User not found!');
    }
}
