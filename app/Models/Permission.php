<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class Permission
 *
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
 * @property int id
 * @property string name
 * @property string guard_name
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Collection|Role[] roles
 * @property Collection|User[] users
 */
class Permission extends \Spatie\Permission\Models\Permission
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = config('database.default');
    }
}
