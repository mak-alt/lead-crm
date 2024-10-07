<?php

namespace App\Observers;

use App\Models\User;
use App\Jobs\SendRegistrationMailJob;


class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $roles = $user->roles()->pluck('slug')->toArray();
        foreach($roles as $role){
            if($role == User::CLIENT){
                if($user->user_no){
                    $user_no = $user->user_no;
                    $user_no = explode('-',$user_no);
                    $user->user_no = intval($user_no[1]) + 1;
                }else{
                    $user_no = 'CL-1';
                }
                $user->save();
            }
        }
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
