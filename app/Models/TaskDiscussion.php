<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $task_id
 * @property integer $user_id
 * @property integer $parent_id
 * @property string $comment
 * @property string $created_at
 * @property string $updated_at
 * @property Task $task
 * @property User $user
 */
class TaskDiscussion extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    // protected $casts = [
    //     'created_at'  => 'date:d M Y - h:i A',
    // ];

    /**
     * @var array
     */
    protected $fillable = ['task_id', 'user_id', 'parent_id', 'comment', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task()
    {
        return $this->belongsTo('App\Models\Task');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    // //get create at date time attribute
    protected function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->timezone(config('app.timezone'))->format('d M Y - h:i A');
    }
}
