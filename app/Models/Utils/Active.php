<?php

namespace App\Models\Utils;

trait Active
{
    /**
     * @return parent
     */
    public static function actives()
    {
        return parent::where('active', '=', true);
    }

    /**
     * @return parent[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getActives()
    {
        return static::actives()->get();
    }
}
