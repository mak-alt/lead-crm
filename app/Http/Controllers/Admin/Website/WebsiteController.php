<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Website;
use App\Models\Role;
use App\Models\LeadStage;
use App\Models\LeadSource;
use DB;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $websites = Website::orderBySort()
                    ->when(request()->name,function($query){
                        return $query->where('name','like','%'.request()->name.'%');
                    })
                    ->when(request()->domain,function($query){
                        return $query->where('domain','like','%'.request()->domain.'%');
                    })
                    ->when(request()->status != "",function($query){
                        return $query->where('status',request()->status);
                    })
                    ->paginate(20);
        return inertia('Admin/Website/Index',[
            'websites' => $websites
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return inertia('Admin/Website/Create');
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
                $website = auth()->user()->websites()->create([
                    'name' => $request->name,
                    'slug' => \Str::slug($request->name),
                    'domain' => $request->domain,
                    'sort' => $request->sort ?? 0
                ]);

                $this->createLeadStages($website->id);
                $this->createLeadSources($website->id);
            });
        } catch(\Exception $exception) {
            return back()->withError($exception->getMessage());
        }

        return back()->withSuccess('Website Created Successfully: )');
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
        $website = Website::findOrFail($id);
        return inertia('Admin/Website/Edit',[
            'website' => $website
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
        $website = Website::find($id)->update([
            'name' => $request->name,
            'slug' => \Str::slug($request->name),
            'domain' => $request->domain
        ]);

        if($website){
            return back()->withSuccess('Website Updated Successfully: )');
        }

        return back()->withError('Whooops! Something went wrong. Please try again :(');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $website = Website::findOrFail($id)->delete();
        if($website){
            return back()->withSuccess('Website Deleted Successfully: )');
        }

        return back()->withError('Whooops! Something went wrong. Please try again :(');
    }

    // update website status
    public function updateStatus(Request $request)
    {   
        $website = Website::findOrFail($request->id);
        $website->status = $request->status;
        $website->save();

        return back()->with('success', 'Status Updated!');
    }

    //bulk delete
    public function bulkDelete(Request $request) 
    {   
        $website = Website::whereIn('id',$request->all_ids)->delete();

        if($website){
            return back()->withSuccess('Websites Deleted Successfully :)');
        }

        return back()->withError('Whooops! Something went wrong. Please try again :(');

    }

    //create webstages
    protected function createLeadStages($website_id)
    {
        $data = [
            ['name' => 'New', 'slug' => 'new', 'color' => '#000', 'sort' => 0, 'website_id' => $website_id],
            ['name' => 'In Process', 'slug' => 'in-process', 'color' => '#000', 'sort' => 0, 'website_id' => $website_id],
            ['name' => 'Converted', 'slug' => 'converted', 'color' => '#000', 'sort' => 0, 'website_id' => $website_id],
        ];
        foreach($data as $row){
            $stage = LeadStage::create($row);
        }

        return true;
    }

    //create web lead sources
    protected function createLeadSources($website_id)
    {
        $data = [
            ['name' => 'Manual', 'slug' => 'manual', 'website_id' => $website_id],
            ['name' => 'Email', 'slug' => 'email', 'website_id' => $website_id],
            ['name' => 'Website', 'slug' => 'website', 'website_id' => $website_id],
        ];
        foreach($data as $row){
            $source = LeadSource::create($row);
        }

        return true;
    }

    //validate request
    protected function validateRequest($id = null){
        if($id){
            $validate = request()->validate([
                'name' => 'required|unique:websites,name,'.$id,
                'domain' => 'required|unique:websites,domain,'.$id
            ]);
        }else{
            $validate = request()->validate([
                'name' => 'required|unique:websites',
                'domain' => 'required|unique:websites'
            ]);
        }

        return $validate;
    } 
}
