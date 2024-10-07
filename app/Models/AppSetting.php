<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $website_id
 * @property string $mail_server
 * @property string $mail_username
 * @property string $mail_password
 * @property string $mail_host
 * @property string $mail_encryption
 * @property string $mail_port
 * @property string $created_at
 * @property string $updated_at
 * @property Website $website
 */
class AppSetting extends Model
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
    protected $fillable = ['website_id', 'mail_server', 'mail_username', 'mail_password', 'mail_host', 'mail_encryption', 'mail_port', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function website()
    {
        return $this->belongsTo('App\Models\Website');
    }
}
