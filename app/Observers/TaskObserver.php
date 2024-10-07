<?php

namespace App\Observers;

use App\Models\Task;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function created(Task $task)
    {
        if($task->parent_id !== 0){
            //get task parent
            $parent_task = Task::with('subtasks')->findOrFail($task->parent_id);
            //check if this task has subtasks
            if($parent_task->subtasks()->count() > 0){
                if($parent_task->subtasks()->count() == 1){
                    $task_no = 1;
                }else{
                    $latest_sub_task = $parent_task->subtasks()->latest()->skip(1)->first()->task_no;
                    $task_no = explode('.',$latest_sub_task);
                    $task_no = intval($task_no[1]) + 1;
                }
            }else{
                $task_no = 1;
            }

            $parent_task = $parent_task->task_no;
            $parent_task = explode('-',$parent_task);
            $task->task_no = 'TK-'.$parent_task[1].'.'.$task_no;
            $task->save();
        }else{
            $task->task_no = 'TK-'.$task->id;
            $task->save();
        }
    }

    /**
     * Handle the Task "created" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function creating(Task $task)
    {
        $task->website_id = core()->currentWebsite()->id;
    }

    /**
     * Handle the Task "updated" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function updated(Task $task)
    {
        //
    }

    /**
     * Handle the Task "deleted" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function deleted(Task $task)
    {
        //
    }

    /**
     * Handle the Task "restored" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function restored(Task $task)
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function forceDeleted(Task $task)
    {
        //
    }
}
