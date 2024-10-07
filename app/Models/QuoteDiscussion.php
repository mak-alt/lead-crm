<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $quote_id
 * @property integer $user_id
 * @property integer $parent_id
 * @property string $comment
 * @property string $created_at
 * @property string $updated_at
 * @property Quote $quote
 * @property User $user
 * @property QuoteDiscussionMedia[] $quoteDiscussionMedia
 */
class QuoteDiscussion extends Model
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
    protected $fillable = ['quote_id', 'user_id', 'parent_id', 'comment', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quote()
    {
        return $this->belongsTo('App\Models\Quote');
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
        return $this->belongsToMany('App\Models\Media', 'quote_discussion_media', 'quote_discussion_id', 'media_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childrens()
    {
        return $this->hasMany('App\Models\QuoteDiscussion', 'parent_id', 'id');
    }
}
