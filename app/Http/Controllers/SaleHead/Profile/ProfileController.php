<?php

namespace App\Http\Controllers\SaleHead\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    //show edit profile page
    public function edit($id)
    {
        $user = User::with(['media','websites','roles'])->findOrFail($id);

        return inertia('SaleHead/Profile/Edit',[
            'user' => $user
        ]);
    }

    //update profile image
    public function updateProfileImage(Request $request, $id){
        $user = User::findOrFail($id);
        if($request->profile){
            $user->addMedia($request->profile)->toMediaCollection('profiles');
        }

        return response()->json('profile updated!');
    }

    // update password
    public function updatePassword(Request $request, $id)
    {
        //validate request
        $validate = $request->validate([
            'old' => 'required|min:8',
            'new' => 'required|min:8',
            'confirm' => 'required|same:new'
        ]);

        //check if old password is correct
        if(\Hash::check($request->old, auth()->user()->password)){
            $user = auth()->user()->update([
                'password' => \Hash::make($request->new)
            ]);

            if($user){
                return back()->withSuccess('Password Updated Successfully :)');
            }

            return back()->withError('Whooops! Something went wrong. Please try again :(');
        }

        return back()->withError('Your old password is not correct.');
    }
}
