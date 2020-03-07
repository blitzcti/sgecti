<?php

namespace App\Models\ManyToMany;

class ModelHasPermission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'permission_id', 'model_type', 'model_morph_key',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'model_has_permissions';
}
