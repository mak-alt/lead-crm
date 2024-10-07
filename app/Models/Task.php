<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Carbon\Carbon;

/**
 * @property integer $id
 * @property integer $task_stage_id
 * @property integer $website_id
 * @property integer $user_id
 * @property string $task_no
 * @property string $name
 * @property string $description
 * @property string $start_date_time
 * @property string $due_date_time
 * @property string $created_at
 * @property string $updated_at
 * @property TaskStage $taskStage
 * @property Website $website
 * @property User $user
 * @property TaskDiscussion[] $taskDiscussions
 */
class Task extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;


    protected $casts = [
        'created_at'  => 'date:d M, Y',
        'start_date_time'  => 'date:d M, Y h:i A',
        'due_date_time'  => 'date:d M, Y h:i A'
    ];

    protected $appends = [
        'original_start_date_time',
        'original_due_date_time',
        'original_description',
        'time_left',
        'priority',
        'start_date_time_local',
        'due_date_time_local',
        'formatted_due_date',
        'expired_due_date'
    ];

    protected $priority = 'Low';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['task_stage_id', 'website_id', 'user_id', 'client_id', 'timezone_id', 'parent_id', 'task_no', 'name', 'description', 'start_date_time', 'due_date_time', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taskStage()
    {
        return $this->belongsTo('App\Models\TaskStage');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function website()
    {
        return $this->belongsTo('App\Models\Website');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taskDiscussions()
    {
        return $this->hasMany('App\Models\TaskDiscussion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany('App\Models\User', 'user_task', 'task_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function timezone()
    {
        return $this->belongsTo('App\Models\Timezone');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo('App\Models\User', 'client_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subtasks()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    /**
     * @return \QueryBuilder
     */
    public function scopeParent($query)
    {
        return $query->where('parent_id', 0);
    }

    public function getDescriptionAttribute($value)
    {
        return \Str::limit($value, 150);
    }

    public function getOriginalDescriptionAttribute($value)
    {
        return $this->getRawOriginal('description');
    }

    public function getOriginalStartDateTimeAttribute()
    {
        return $this->getRawOriginal('start_date_time');
    }

    public function getOriginalDueDateTimeAttribute()
    {
        return $this->getRawOriginal('due_date_time');
    }

    public function getTimeLeftAttribute()
    {
        if($this->original_start_date_time && $this->original_due_date_time){
            if(Carbon::now()->format('Y-m-d h:i:s') <= $this->original_due_date_time){
                $start_date = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->format('Y-m-d h:i:s'));
                $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $this->original_due_date_time);

                $days = $start_date->diffInDays($end_date);
                $hours = $start_date->copy()->addDays($days)->diffInHours($end_date);
                $minutes = $start_date->copy()->addDays($days)->addHours($hours)->diffInMinutes($end_date);

                $result = '';

                if($days > 0){
                    if($days == 1){
                        $result .= $days.' day ';
                    }else{
                        $result .= $days.' days ';
                    }
                }

                if($hours > 0){
                    $result .= $hours. ' hrs ';
                }

                if($minutes > 0){
                    $result .= $minutes. ' mins ';
                }

                return $result;
            }

            return 'Date Expired';
        }

        return 'Due Date Not Assigned';
    }

    public function getPriorityAttribute()
    {
        if($this->original_start_date_time && $this->original_due_date_time){
            $start_date = Carbon::createFromFormat('Y-m-d H:i:s', $this->original_start_date_time);
            $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $this->original_due_date_time);

            $hours = $start_date->diffInHours($end_date);

            if($hours <= 48){
                return $this->priority = 'High';
            }elseif($hours <= 96){
                return $this->priority = 'Medium';
            }else{
                return $this->priority;
            }
        }
    }

    protected function getStartDateTimeLocalAttribute()
    {
        if($this->getRawOriginal('start_date_time')){
            return Carbon::parse($this->getRawOriginal('start_date_time'),$this->timezone->name)
                        ->setTimezone(config('app.timezone'))
                        ->format('d M, Y h:i A');
        }

        return '-';
    }

    protected function getDueDateTimeLocalAttribute()
    {
        if($this->getRawOriginal('due_date_time')){
            return Carbon::parse($this->getRawOriginal('due_date_time'),$this->timezone->name)
                        ->setTimezone(config('app.timezone'))
                        ->format('d M, Y h:i A');
        }

        return '-';
    }

    //get formatted due date
    protected function getFormattedDueDateAttribute()
    {
        return Carbon::parse($this->getRawOriginal('due_date_time'))->format('d M, Y');
    }

    //check due date time expiry
    protected function getExpiredDueDateAttribute()
    {
        if($this->getRawOriginal('due_date_time') < Carbon::now()){
            return false;
        }
    }
}
