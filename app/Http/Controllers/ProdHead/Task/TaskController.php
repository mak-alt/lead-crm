<?php

namespace App\Http\Controllers\ProdHead\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Task,
    TaskStage,
    User
};
use App\Events\{
    TaskWasAdded,
    MembersAttachedInTask
};
use DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            DB::transaction(function() use ($request,&$task){
                $task = auth()->user()->taskBy()->create($request->except(['members']));
                event(new TaskWasAdded($task));

                $members = $request->members ?? [];
                if(count($members)){
                    $task->members()->attach($members);
                    $members = User::whereIn('id',$members)->get();
                    event(new MembersAttachedInTask($members, $task));
                }

                if(count($request->myFiles) > 0){
                    foreach ($request->myFiles as $key => $value) {
                        $task->addMedia($value)->toMediaCollection('tasks');
                    }
                }
            });

        } catch(\Exception $exception) {
            return back()->withError($exception->getMessage());
        }

        return back()->withSuccess('Task Created Successfully :)');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug, $id, $team_id)
    {
        $task = Task::with(['taskStage','members','media','taskDiscussions','client','subtasks'])->withCount(['taskDiscussions'])->findOrFail($id);
        $stages = TaskStage::whereTeamId($team_id)->get();
        //get existing team member ids
        $existing = [];
        if($task->members->count() > 0){
            foreach($task->members as $member){
                $existing[] = $member->id;
            }
        }
        $members = User::withRoleProduction()->whereNotIn('id',$existing)->get();

        return inertia('ProdHead/Task/Show',[
            'task' => $task,
            'stages' => $stages,
            'members' => $members
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Update Task Status
     * 
     */
    public function updateStatus(Request $request, $slug, $id)
    {
        $task = Task::findOrFail($id)->update(['task_stage_id' => $request->stage_id]);

        if($task){
            return response()->json(['task' => $request->stage_id, 'success' => true, 'message' => 'Status Updated!']);
        }

        return response()->json(['task' => null, 'success' => true, 'message' => 'Something went wrong']);
    }

    /**
     * Attach new members in task
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addMembers(Request $request, $slug, $id)
    {
        $task = Task::findOrFail($id);

        if(count($request->members) > 0){
            $task->members()->attach($request->members);
            $members = User::whereIn('id', $request->members)->get();
            event(new MembersAttachedInTask($members, $task));
        }

        if($task){
            return back()->withSuccess('Members Assigned Successfully :)');
        }

        return back()->withError('Whooops! Something went wrong. Please try again :(');
    }

    /**
     * Remove attached members from task
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function removeMember(Request $request, $slug, $task_id, $id)
    {
        $task = Task::findOrFail($task_id)->members()->detach([$id]);

        if($task){
            return back()->withSuccess('Member Removed Successfully :)');
        }

        return back()->withError('Whooops! Something went wrong. Please try again :(');
    }

    //upload media
    public function uploadMedia(Request $request, $slug, $id)
    {
        $task = Task::findOrFail($id);

        if(count($request->myFiles) > 0){
            foreach ($request->myFiles as $key => $value) {
                $task->addMedia($value)->toMediaCollection('tasks');
            }
        }

        if($task){
            return back()->withSuccess('Resource Uploaded Successfully: )');
        }

        return back()->withError('Whooops! Something went wrong. Please try again :(');
    }

    //update summary
    public function updateSummary(Request $request, $slug, $id)
    {   
        $task = Task::findOrFail($id);
        $task->description = $request->description;
        $task->save();

        return back()->withSuccess($task->task_no.' Summary Updated Successfully: )');
    }

    //update dates
    public function updateDates(Request $request, $slug, $id)
    {   
        $task = Task::findOrFail($id);
        $task->start_date_time = $request->start_date_time;
        $task->due_date_time = $request->due_date_time;
        $task->save();

        return back()->withSuccess($task->task_no.' Dates Updated Successfully: )');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSubtask(Request $request, $slug)
    {
        request()->validate([
            'name' => 'required|string|max:65',
            'due_date_time' => 'required'
        ]);

        try{ 
            DB::transaction(function() use ($request){
                $task = auth()->user()->taskBy()->create($request->all());
            });

        } catch(\Exception $exception) {
            return back()->withError($exception->getMessage());
        }

        return back()->withSuccess('Sub Task Created Successfully :)');
    }

    /**
     * Update an existing resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateSubtask(Request $request, $slug, $id)
    {
        request()->validate([
            'name' => 'required|string|max:65',
            'due_date_time' => 'required'
        ]);

        try{ 
            DB::transaction(function() use ($request,$id){
                $task = Task::findOrFail($id);
                $task->name = $request->name;
                $task->due_date_time = $request->due_date_time;
                $task->save();
            });

        } catch(\Exception $exception) {
            return back()->withError($exception->getMessage());
        }

        return back()->withSuccess('Sub Task Updated Successfully :)');
    }

    /**
     * Update Subtask Status 
     */
    public function updateSubtaskStatus(Request $request, $slug, $id)
    {
        $task = Task::findOrFail($id);
        $task->is_completed = $request->is_completed;
        $task->save();

        return response()->json(['data' => $task, 'success' => true]);
    }

    /**
     * Validate Request
     * 
     */
    protected function validateRequest()
    {
        request()->validate([
            'client_id' => 'required',
            'name' => 'required|string|max:65'
        ]);
    }
}
