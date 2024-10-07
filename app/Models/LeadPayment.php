<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $lead_id
 * @property integer $user_id
 * @property float $amount
 * @property boolean $status
 * @property string $created_at
 * @property string $updated_at
 * @property Lead $lead
 * @property User $user
 */
class LeadPayment extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    protected $casts = [
        'created_at'  => 'date:d M, Y',
    ];

    /**
     * @var array
     */
    protected $fillable = ['lead_id', 'user_id', 'amount', 'status', 'date', 'mode', 'created_at', 'updated_at'];

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
}
