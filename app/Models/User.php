<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Traits\Role;

/**
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $email_verified_at
 * @property string $password
 * @property string $remember_token
 * @property string $created_at
 * @property string $updated_at
 * @property Lead[] $leads
 * @property LeadLog[] $leadLogs
 * @property Quote[] $quotes
 * @property QuoteDiscussion[] $quoteDiscussions
 * @property QuoteLog[] $quoteLogs
 * @property Team[] $teams
 * @property UserMedia[] $userMedia
 * @property UserRole[] $userRoles
 * @property UserTeam[] $userTeams
 * @property UserWebsite[] $userWebsites
 */
class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia, Role;


    const SUPER_ADMIN = 'super-admin';
    const PARTNER = 'partner';
    const CLIENT = 'client';
    const SALES_HEAD = 'sales-head';
    const SALES = 'sales';
    const PROD_HEAD = 'production-head';
    const PROD = 'production';


    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    protected $appends = ['profile_image'];

    /**
     * @var array
     */
    protected $fillable = ['user_no', 'name', 'email', 'phone', 'email_verified_at', 'password', 'remember_token', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function leads()
    {
        return $this->hasMany('App\Models\Lead', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clientLeads()
    {
        return $this->hasMany('App\Models\Lead', 'client_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function leadDiscussions()
    {
        return $this->hasMany('App\Models\LeadDiscussion');
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
    public function quoteDiscussions()
    {
        return $this->hasMany('App\Models\QuoteDiscussion');
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
    public function leadPayments()
    {
        return $this->hasMany('App\Models\LeadPayment');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'user_role', 'user_id', 'role_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teamMembers()
    {
        return $this->belongsToMany('App\Models\Team', 'user_team', 'user_id', 'team_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tasks()
    {
        return $this->belongsToMany('App\Models\Task', 'user_task', 'user_id', 'task_id');
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
    public function websites()
    {
        return $this->belongsToMany('App\Models\Website', 'user_website', 'user_id', 'website_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function leadBy()
    {
        return $this->hasMany('App\Models\Lead');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taskBy()
    {
        return $this->hasMany('App\Models\Task');
    }

    /**
     * Get the user's image.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function getProfileImageAttribute($value)
    {
        if($this->getMedia('profiles')->count() > 0){
            if(\File::exists($this->getMedia('profiles')->last()->getPath())){
                return $this->getMedia('profiles')->last()->original_url;
            }
        }

        return asset('public/assets/images/users/avatar-1.jpg');
    }

    /**
     *
     * Set Password Attribute Hash
     */
    protected function setPasswordAttribute($value)
    {
        if($value){
            return $this->attributes['password'] = \Hash::make($value);
        }

        return $this->attributes['password'] = NULL;
    }

    /**
     * Check if User Is Admin
     *
     * @return Collection
     */
    public function isSuperAdmin()
    {
        return $this->superAdmin();
    }

    /**
     * Check if User Is Partner
     *
     * @return Collection
     */
    public function isPartner()
    {
        return $this->partner();
    }

    /**
     * Check if User Is Sales Head
     *
     * @return Collection
     */
    public function isSalesHead()
    {
        return $this->salesHead();
    }

    /**
     * Check if User Is Sales Head
     *
     * @return Collection
     */
    public function isSales()
    {
        return $this->sales();
    }

    /**
     * Check if User Is Sales Head
     *
     * @return Collection
     */
    public function isProductionHead()
    {
        return $this->productionHead();
    }

    /**
     * Check if User Is Sales Head
     *
     * @return Collection
     */
    public function isProduction()
    {
        return $this->production();
    }
    

    /**
     * Check if User Is Sales Head
     *
     * @return Collection
     */
    public function isClient()
    {
        return $this->client();
    }

    /**
     * Get User Role
     */
    public function hasRole()
    {
        return $this->isRole();
    }

    /**
     * Scope For Active Users
     */
    public function scopeActive($query)
    {
        return $query->whereStatus(1);
    }

    /**
     * Scope For Active Users
     */
    public function scopewithRoleClient()
    {
        return $this->whereHas('roles',function($query){
            $query->where('slug', static::CLIENT);
        });
    }


    protected function scopeWithRoleProduction()
    {
        return $this->whereHas('roles',function($query){
            $query->where('slug', static::PROD);
        });
    }
}
