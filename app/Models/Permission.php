<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Model for permissions table (created for IDE Helper).
 *
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
 *
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

    public function getRolesAttribute()
    {
        if (!config('broker.useSSO')) {
            return $this->roles()->get();
        }

        $roles = array_column(DB::table(config('permission.table_names.role_has_permissions'))->where('permission_id', $this->id)->get('role_id')->toArray(), 'role_id');
        return Role::whereIn('id', $roles)->get();
    }
}
