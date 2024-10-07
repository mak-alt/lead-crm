<?php

namespace App\Http\Controllers\Partner\LeadDiscussion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeadDiscussion;
use App\Events\LeadDiscussionEvent;

class LeadDiscussionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $discussions = LeadDiscussion::with(['user','user.media'])->whereLeadId($request->lead_id)->get();

        return response()->json($discussions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $discussion = auth()->user()->leadDiscussions()->create([
            'comment' => $request->comment,
            'lead_id' => $request->lead_id
        ]);

        $discussion = LeadDiscussion::with('user')->findOrFail($discussion->id);

        broadcast(new LeadDiscussionEvent(auth()->user(), $discussion))->toOthers();

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
