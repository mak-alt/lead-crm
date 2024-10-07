<?php

namespace App\Http\Controllers\Partner\Lead;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\LeadStage;
use App\Models\LeadSource;
use App\Models\Timezone;
use App\Models\User;
use App\Events\LeadWasAdded;
use DB;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leads = Lead::with(['stage', 'source', 'user', 'client'])
                ->when(request()->search, function($query){
                    return $query->where('lead_no','like','%'.request()->search.'%');
                })
                ->when(request()->due_date, function($query){
                    return $query->whereDate('due_date_time',request()->due_date);
                })
                ->whereWebsiteId(core()->currentWebsite()->id)
                ->latest()
                ->paginate(20)->withQueryString();

        $lead_stages = LeadStage::orderBy('sort','asc')
                    ->withCount('leads')
                    ->whereWebsiteId(core()->currentWebsite()->id)
                    ->get();

                    
        return inertia('Partner/Lead/Index',[
            'leads' => $leads,
            'lead_stages' => $lead_stages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stages = LeadStage::whereWebsiteId(core()->currentWebsite()->id)->get();
        $sources = LeadSource::whereWebsiteId(core()->currentWebsite()->id)->get();
        $timezones = Timezone::all();
        $clients = User::withRoleClient()->get();

        return inertia('Partner/Lead/Create',[
            'stages' => $stages,
            'sources' => $sources,
            'timezones' => $timezones,
            'clients' => $clients
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
                $lead = new Lead();
                $lead->description = $request->description;
                $lead->subject = $request->subject;
                $lead->type = $request->type;
                $lead->start_date_time = $request->start_date_time;
                $lead->due_date_time = $request->due_date_time;
                $lead->timezone_id = $request->timezone_id;
                $lead->priority = $request->priority;
                $lead->expected_amount = $request->expected_amount;
                $lead->lead_stage_id = $request->stageId;
                $lead->lead_source_id = $request->sourceId;
                $lead->meta = $request->meta ?? [];
                $lead->client_id = $request->client_id;
                $lead->website_id = core()->currentWebsite()->id;
                $lead->user_id = auth()->user()->id;
                $lead->save();

                if(count($request->myFiles) > 0){
                    foreach ($request->myFiles as $key => $value) {
                        $lead->addMedia($value)->toMediaCollection('leads');
                    }
                }

                event(new LeadWasAdded($lead));

            });
        } catch(\Exception $exception) {
            return back()->withError($exception->getMessage());
        }

        return back()->withSuccess('Lead Created Successfully: )');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug, $id)
    {   
        $lead = Lead::with(['stage','source','user','client','media','payments','payments.user','timezone'])->findOrFail($id);
        return inertia('Partner/Lead/Show',[
            'lead' => $lead
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug, $id)
    {
        $lead = Lead::with(['stage', 'source'])->findOrFail($id);
        $stages = LeadStage::whereWebsiteId(core()->currentWebsite()->id)->get();
        $sources = LeadSource::whereWebsiteId(core()->currentWebsite()->id)->get();
        $timezones = Timezone::all();
        $clients = User::withRoleClient()->get();

        return inertia('Partner/Lead/Edit',[
            'lead' => $lead,
            'stages' => $stages,
            'sources' => $sources,
            'timezones' => $timezones,
            'clients' => $clients
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug, $id)
    {
        $this->validateRequest();

        try{
            DB::transaction(function() use ($request,$id){
                $lead = Lead::findOrFail($id);
                $lead->description = $request->description;
                $lead->subject = $request->subject;
                $lead->type = $request->type;
                $lead->start_date_time = $request->start_date_time;
                $lead->due_date_time = $request->due_date_time;
                $lead->timezone_id = $request->timezone_id;
                $lead->priority = $request->priority;
                $lead->expected_amount = $request->expected_amount;
                $lead->lead_stage_id = $request->stageId;
                $lead->lead_source_id = $request->sourceId;
                $lead->client_id = $request->client_id;
                $lead->save();
            });
        } catch(\Exception $exception) {
            return back()->withError($exception->getMessage());
        }

        return back()->withSuccess('Lead Updated Successfully: )');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug, $id)
    {
        $lead = Lead::findOrFail($id)->delete();

        if($lead){
            return back()->withSuccess('Lead Deleted Successfully: )');
        }

        return back()->withError('Whooops! Something went wrong. Please try again :(');
    }

    //bulk delete
    public function bulkDelete(Request $request) 
    {   
        $lead = Lead::whereIn('id',$request->all_ids)->delete();

        if($lead){
            return back()->withSuccess('Leads Deleted Successfully :)');
        }

        return back()->withError('Whooops! Something went wrong. Please try again :(');

    }

    //update expected amount
    public function updateExpectedAmount(Request $request, $slug, $id)
    {
        $lead = Lead::findOrFail($id);
        $lead->expected_amount = $request->expected_amount;
        $lead->save();

        if($lead){
            return back()->withSuccess('You can create the payments :)');
        }

        return back()->withError('Whooops! Something went wrong. Please try again :(');
    }

    //upload media
    public function uploadMedia(Request $request, $slug, $id)
    {
        $lead = Lead::findOrFail($id);

        if(count($request->myFiles) > 0){
            foreach ($request->myFiles as $key => $value) {
                $lead->addMedia($value)->toMediaCollection('leads');
            }
        }

        if($lead){
            return back()->withSuccess('Resource Uploaded Successfully: )');
        }

        return back()->withError('Whooops! Something went wrong. Please try again :(');
    }

    //validation
    protected function validateRequest()
    {
        $validate = request()->validate([
            'client_id' => 'required|numeric',
        ]);

        return $validate;
    }
}
