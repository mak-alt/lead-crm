<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $domain
 * @property integer $sort
 * @property string $created_at
 * @property string $updated_at
 * @property AppSetting[] $appSettings
 * @property Lead[] $leads
 * @property LeadSource[] $leadSources
 * @property LeadStage[] $leadStages
 * @property Medium[] $media
 * @property Quote[] $quotes
 * @property Role[] $roles
 * @property Team[] $teams
 * @property UserWebsite[] $userWebsites
 */
class Website extends Model
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
    protected $fillable = ['name', 'slug', 'domain', 'sort', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appSettings()
    {
        return $this->hasMany('App\Models\AppSetting');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function leads()
    {
        return $this->hasMany('App\Models\Lead');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function leadSources()
    {
        return $this->hasMany('App\Models\LeadSource');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function leadStages()
    {
        return $this->hasMany('App\Models\LeadStage');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function media()
    {
        return $this->hasMany('App\Models\Media');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quotes()
    {
        return $this->hasMany('App\Models\Quote');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teams()
    {
        return $this->hasMany('App\Models\Team');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User','user_website','website_id','user_id');
    }

    /**
     * Scope For Active Website
     */
    protected function scopeActive($query)
    {
        $query->whereStatus(1);
    }

    //order by sort col
    protected function orderBySort($def = 'ASC'){
        return $this->orderBy('sort',$def);
    }
}
