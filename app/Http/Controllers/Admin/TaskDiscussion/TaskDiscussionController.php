<?php

namespace App\Http\Controllers\Admin\TaskDiscussion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\TaskDiscussionEvent;
use App\Models\{
    TaskDiscussion,
};

class TaskDiscussionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $discussions = TaskDiscussion::with(['user','user.media'])->whereTaskId($request->task_id)->get();

        return response()->json($discussions);
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
    public function store(Request $request)
    {
        $discussion = auth()->user()->taskDiscussions()->create([
            'comment' => $request->comment,
            'task_id' => $request->task_id
        ]);

        $discussion = TaskDiscussion::with('user')->findOrFail($discussion->id);

        broadcast(new TaskDiscussionEvent(auth()->user(), $discussion))->toOthers();

        return response()->json($discussion);
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
}
