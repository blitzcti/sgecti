<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * Model for notifications table (created for IDE Helper).
 *
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
 *
 * @property string id
 * @property string type
 * @property string notifiable_type
 * @property int notifiable_id
 * @property string data
 * @property Carbon read_at
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class DatabaseNotification extends \Illuminate\Notifications\DatabaseNotification
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = config('database.default');
    }
}
