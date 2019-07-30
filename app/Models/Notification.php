<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'short_text', 'text', 'read',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
