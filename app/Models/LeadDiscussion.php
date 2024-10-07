<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $lead_id
 * @property integer $user_id
 * @property integer $parent_id
 * @property string $comment
 * @property string $created_at
 * @property string $updated_at
 * @property Lead $lead
 * @property Lead $lead
 * @property LeadDiscussionMedia[] $leadDiscussionMedia
 */
class LeadDiscussion extends Model
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
    protected $fillable = ['lead_id', 'user_id', 'parent_id', 'comment', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lead()
    {
        return $this->belongsTo('App\Models\Lead');
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
    public function media()
    {
        return $this->hasMany('App\Models\Media', 'lead_discussion_media', 'lead_id', 'media_id');
    }

    //get childrens
    
    public function childrens()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    // //get create at date time attribute
    protected function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->timezone(config('app.timezone'))->format('d M Y - h:i A');
    }
}
