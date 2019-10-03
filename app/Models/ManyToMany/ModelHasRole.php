<?php

namespace App\Models\ManyToMany;

class ModelHasRole extends Model
{
    protected $fillable = [
        'role_id', 'model_type', 'model_morph_key',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'model_has_roles';
}
