<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $website_id
 * @property string $name
 * @property string $slug
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property Website $website
 * @property UserTeam[] $userTeams
 */
class Team extends Model
{
    use HasFactory;

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'website_id', 'team_no', 'name', 'slug', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function website()
    {
        return $this->belongsTo('App\Models\Website');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members()
    {
        return $this->belongsToMany('App\Models\User', 'user_team', 'team_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taskStages()
    {
        return $this->hasMany('App\Models\TaskStage');
    }

    /**
     * Scope For Active Team
     * 
     */
    protected function scopeActive($query)
    {
        return $query->whereStatus(1);
    }
}
