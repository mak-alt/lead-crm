<?php

namespace App\Http\Controllers\ProdHead\Team;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\User;
use App\Models\Website;
use App\Models\TaskStage;
use App\Models\Timezone;
use App\Events\TeamWasAdded;
use App\Events\MembersAttachedInTeam;
use DB;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::latest()
                ->with(['user','members'])
                ->when(request()->team_no,function($query){
                    return $query->where('team_no',request()->team_no);
                })
                ->whereWebsiteId(core()->currentWebsite()->id)
                ->paginate(20);

        $members = User::whereHas('roles',function($query){
            $query->where('slug','production');
        })->get();

        return inertia('ProdHead/Team/Index',[
            'teams' => $teams,
            'members' => $members
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('ProdHead/Team/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $slug)
    {
        $this->validateRequest();
        try{
            DB::transaction(function() use ($request){
                $team = auth()->user()->teams()->create([
                    'name' => $request->name,
                    'slug' => \Str::slug($request->name),
                    'website_id' => core()->currentWebsite()->id,
                ]);
                $this->attachTaskStage($team);
                event(new TeamWasAdded($team));

                if(count($request->members) > 0){
                    $team->members()->attach($request->members);
                    event(new MembersAttachedInTeam($team));
                }
            });
        } catch(\Exception $exception) {
            return back()->withError($exception->getMessage());
        }

        return back()->withSuccess('Team Created Successfully :)');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug, $id)
    {
        $team = Team::with('members')->findOrFail($id);
        $stages = TaskStage::with(['tasks','tasks.taskDiscussions','tasks.members','tasks.user'])
                ->withCount(['tasks'])
                ->whereTeamId($id)
                ->orderBy('sort','asc')
                ->get();

        //get existing team member ids
        $existing = [];
        if($team->members->count() > 0){
            foreach($team->members as $member){
                $existing[] = $member->id;
            }
        }
        $members = User::withRoleProduction()->whereNotIn('id',$existing)->get();
        $clients = User::withRoleClient()->get();
        $timezones = Timezone::all();

        return inertia('ProdHead/Team/Show',[
            'team' => $team,
            'stages' => $stages,
            'members' => $members,
            'clients' => $clients,
            'timezones' => $timezones
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
        $team = Team::findOrFail($id);

        return inertia('ProdHead/Team/Edit',[
            'team' => $team
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
        $this->validateRequest($id);

        $team = Team::findOrFail($id)->update($request->all());

        if($team){
            return back()->withSuccess('Team Updated Successfully :)');
        }

        return back()->withError('Whooops! Something went wrong. Please try again :(');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug, $id)
    {
        $team = Team::findOrFail($id)->delete();

        if($team){
            return back()->withSuccess('Team Deleted Successfully :)');
        }

        return back()->withError('Whooops! Something went wrong. Please try again :(');
    }

    // update website status
    public function updateStatus(Request $request, $slug)
    {   
        $team = Team::findOrFail($request->id);
        $team->status = $request->status;
        $team->save();

        return back()->with('success', 'Status Updated!');
    }

    //bulk delete
    public function bulkDelete(Request $request, $slug) 
    {   
        $team = Team::whereIn('id',$request->all_ids)->delete();

        if($team){
            return back()->withSuccess('Teams Deleted Successfully :)');
        }

        return back()->withError('Whooops! Something went wrong. Please try again :(');

    }

    /**
     * Store a newly created members in team.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addMembers(Request $request, $slug, $id)
    {
        $team = Team::findOrFail($id);

        if(count($request->members) > 0){
            $team->members()->attach($request->members);
        }

        if($team){
            event(new MembersAttachedInTeam($team));
            return back()->withSuccess('Members Added Successfully :)');
        }

        return back()->withError('Whooops! Something went wrong. Please try again :(');
    }

    //attach task stage
    public function attachTaskStage($team)
    {
        $team->taskStages()->create([
            'name' => 'Unassigned',
            'slug' => 'unassigned',
            'color' => '#000',
            'sort' => 0
        ]);

        return true;
    }

    //validate request
    protected function validateRequest($id = null){
        if($id){
            $validate = request()->validate([
                'name' => 'required|unique:teams,name,'.$id,
            ]);
        }else{
            $validate = request()->validate([
                'name' => 'required|unique:teams',
            ]);
        }

        return $validate;
    } 
}
