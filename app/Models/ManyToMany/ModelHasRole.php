<?php

namespace App\Models\ManyToMany;

class ModelHasRole extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id', 'model_type', 'model_morph_key',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'model_has_roles';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = config('broker.useSSO') ? config('database.sso') : config('database.default');
    }
}
