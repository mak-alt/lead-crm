<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    User,
    Role,
    Website
};
use App\Events\{
    RegistrationWillComplete
};
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with(['roles', 'websites'])
                    ->when(request()->name,function($query){
                        return $query->where('name','like','%'.request()->name.'%');
                    })
                    ->when(request()->email,function($query){
                        return $query->where('email','like','%'.request()->email.'%');
                    })
                    ->when(request()->status != "",function($query){
                        return $query->where('status',request()->status);
                    })
                    ->latest()
                    ->paginate(20);
        return inertia('Admin/User/Index',[
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $websites = Website::whereStatus(1)->get();
        $roles = Role::withoutRole('super-admin')->whereStatus(1)->get();

        return inertia('Admin/User/Create',[
            'websites' => $websites,
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateRequest();
        try{
            DB::transaction(function() use ($request){
                $user = User::create($request->all());

                //assign websites
                if(count($request->websiteIds) > 0){
                    $user->websites()->attach($request->websiteIds);
                }

                //assign roles
                if($request->roleId){
                    $user->roles()->attach([$request->roleId]);
                    $this->setClientID($user);
                }

                event(new RegistrationWillComplete($user));
            });
        } catch(\Exception $exception) {
            return back()->withError($exception->getMessage());
        }

        return back()->withSuccess('User Created Successfully: )');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with(['roles', 'websites'])->findOrFail($id);
        $websites = Website::whereStatus(1)->get();
        $roles = Role::withoutRole('super-admin')->whereStatus(1)->get();

        return inertia('Admin/User/Edit',[
            'user' => $user,
            'websites' => $websites,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validateRequest($id);
        try{
            DB::transaction(function() use ($request,$id){
                $user = User::findOrFail($id);
                $user->name = $request->name;
                $user->save();

                //assign websites
                if(count($request->websiteIds) > 0){
                    $user->websites()->sync($request->websiteIds);
                }

                //assign roles
                if($request->roleId){
                    $user->roles()->sync([$request->roleId]);
                    $this->setClientID($user);
                }
            });
        }
        catch(\Exception $exception) {
            return back()->withError($exception->getMessage());
        }
        
        return back()->withSuccess('User Updated Successfully: )');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id)->delete();

        if($user){
            return back()->withSuccess('User Deleted Successfully: )');
        }

        return back()->withError('Whooops! Something went wrong. Please try again :(');
    }

    // update user status
    public function updateStatus(Request $request)
    {   
        $user = User::findOrFail($request->id);
        $user->status = $request->status;
        $user->save();

        return back()->with('success', 'Status Updated!');
    }

    //bulk delete
    public function bulkDelete(Request $request) 
    {   
        $user = User::whereIn('id',$request->all_ids)->delete();

        if($user){
            return back()->withSuccess('Users Deleted Successfully :)');
        }

        return back()->withError('Whooops! Something went wrong. Please try again :(');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeClientFromLead(Request $request)
    {
        $this->validateRequest();
        try{
            DB::transaction(function() use ($request,&$user){
                $user = User::create($request->all());

                //assign websites
                if(core()->currentWebsite()){
                    $user->websites()->attach([core()->currentWebsite()->id]);
                }

                //get client role
                $role = Role::whereSlug('client')->first();

                //assign roles
                if($role){
                    $user->roles()->attach([$role->id]);
                    $this->setClientID($user);
                }

                event(new RegistrationWillComplete($user));
            });
        } catch(\Exception $exception) {
            return back()->withError($exception->getMessage());
        }

        return back()->withSuccess('User Created Successfully: )');
    }

    //set client no
    protected function setClientID($user)
    {
        if(!$user->user_no){
            $roles = $user->roles()->pluck('slug')->toArray();
            foreach($roles as $role){
                if($role == User::CLIENT){
                    //get last user no
                    $last_client = User::whereHas('roles',function($query){
                        $query->where('slug',User::CLIENT);
                    })->whereNotNull('user_no')->orderBy('id','desc')->first();
                    if(isset($last_client->user_no)){
                        $user_no = $last_client->user_no;
                        $user_no = explode('-',$user_no);
                        $user->user_no = 'CL-'.intval($user_no[1]) + 1;
                        $user->save();
                    }else{
                        $user->user_no = 'CL-1';
                        $user->save();
                    }
                }
            }
        }
    }

    //validation
    protected function validateRequest($id = null)
    {
        if($id){
            $validate = request()->validate([
                'name' => 'required|min:3|max:65',
                'email' => 'required|email|unique:users,id,'.$id,
            ]);
        }else{
            $validate = request()->validate([
                'name' => 'required|min:3|max:65',
                'email' => 'required|unique:users',
                'password' => 'nullable',
            ]);
        }

        return $validate;
    }
}
