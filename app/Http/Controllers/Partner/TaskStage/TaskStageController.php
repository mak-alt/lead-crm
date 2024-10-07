<?php

namespace App\Http\Controllers\Partner\TaskStage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskStage;

class TaskStageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        $stage = new TaskStage();
        $stage->name = $request->name;
        $stage->slug = \Str::slug($request->name);
        $stage->color = $request->color ?? NULL;
        $stage->sort = 0;
        $stage->team_id = $request->team_id;
        $stage->save();

        if($stage){
            return back()->withSuccess('Stage Created Successfully :)');
        }

        return back()->withError('Whooops! Something went wrong. Please try again :(');
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

    protected function validateRequest()
    {
        request()->validate([
            'name' => 'required|string|max:65'
        ]);
    }
}
