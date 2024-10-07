<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Carbon\Carbon;

/**
 * @property integer $id
 * @property integer $lead_stage_id
 * @property integer $lead_source_id
 * @property integer $website_id
 * @property integer $user_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $description
 * @property string $meta
 * @property string $created_at
 * @property string $updated_at
 * @property Website $website
 * @property LeadSource $leadSource
 * @property User $user
 * @property LeadStage $leadStage
 * @property LeadDiscussion[] $leadDiscussions
 * @property LeadDiscussion[] $leadDiscussions
 * @property LeadLog[] $leadLogs
 * @property LeadMedia[] $leadMedia
 */
class Lead extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    protected $casts = [
        'created_at'  => 'date:d M, Y',
        'start_date_time'  => 'date:d M, Y h:i A',
        'due_date_time'  => 'date:d M, Y h:i A',
        'start_date_time_local'  => 'date:d M, Y h:i A',
        'due_date_time_local'  => 'date:d M, Y h:i A',
        'meta' => 'array'
    ];

    protected $appends = [
        'original_start_date_time',
        'original_due_date_time',
        'paid',
        'refund',
        'remaining',
        'start_date_time_local',
        'due_date_time_local'
    ];

    /**
     * @var array
     */
    protected $fillable = ['timezone_id', 'lead_stage_id', 'lead_source_id', 'lead_no', 'website_id', 'user_id', 'client_id', 'subject', 'type', 'description', 'meta', 'is_converted', 'start_date_time', 'due_date_time', 'priority', 'created_at', 'updated_at'];

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
    public function source()
    {
        return $this->belongsTo('App\Models\LeadSource', 'lead_source_id', 'id');
    }

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
    public function stage()
    {
        return $this->belongsTo('App\Models\LeadStage', 'lead_stage_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function discussions()
    {
        return $this->hasMany('App\Models\LeadDiscussion')->with('user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany('App\Models\LeadPayment');
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

    public function getOriginalStartDateTimeAttribute()
    {
        return $this->getRawOriginal('start_date_time');
    }

    public function getOriginalDueDateTimeAttribute()
    {
        return $this->getRawOriginal('due_date_time');
    }

    //get paid payments
    public function getPaidAttribute()
    {
        return $this->payments()->where('status', 1)->sum('amount');
    }

    //get refund payments
    public function getRefundAttribute()
    {
        return $this->payments()->where('status', 0)->sum('amount');
    }

    //get remaining payments
    public function getRemainingAttribute()
    {
        $paid = floatval($this->getPaidAttribute());
        $refund = floatval($this->getRefundAttribute());
        if($paid === 0 || $refund === 0){
            return ($this->expected_amount) - $paid;
        }
        return $this->expected_amount - ($paid - $refund);
    }

    //set websiteId Attribute
    protected function setWebsiteIdAttribute($value)
    {
        $this->attributes['website_id'] = core()->currentWebsite()->id;
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
}
