<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $website_id
 * @property integer $user_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $description
 * @property string $meta
 * @property string $status
 * @property string $source
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property Website $website
 * @property QuoteDiscussion[] $quoteDiscussions
 * @property QuoteLog[] $quoteLogs
 * @property QuoteMedia[] $quoteMedia
 */
class Quote extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['website_id', 'user_id', 'name', 'email', 'phone', 'description', 'meta', 'status', 'source', 'created_at', 'updated_at'];

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
    public function discussions()
    {
        return $this->hasMany('App\Models\QuoteDiscussion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quoteLogs()
    {
        return $this->hasMany('App\Models\QuoteLog');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function media()
    {
        return $this->belongsToMany('App\Models\Media', 'quote_media', 'quote_id', 'media_id');
    }
}
