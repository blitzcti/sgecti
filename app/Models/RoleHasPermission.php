<?php

namespace App\Models;

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

    /**
     * primaryKey
     *
     * @var integer
     * @access protected
     */
    protected $primaryKey = null;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
}
