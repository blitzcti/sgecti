<?php

namespace App\Models;

class ModelHasPermission extends Model
{
    protected $fillable = [
        'permission_id', 'model_type', 'model_morph_key',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'model_has_permissions';

    /**
     * primaryKey
     *
     * @var string
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
