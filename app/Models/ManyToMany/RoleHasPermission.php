<?php

namespace App\Models\ManyToMany;

class RoleHasPermission extends Model
{
    protected $fillable = [
        'permission_id', 'role_id',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'role_has_permissions';
}
