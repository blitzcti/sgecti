<?php

namespace App\Models;

class PasswordReset extends Model
{
    protected $fillable = [
        'email', 'token',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'model_has_roles';

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
