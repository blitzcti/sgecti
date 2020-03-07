<?php

namespace App\AdminLTE;

use App\Auth;
use JeroenNoten\LaravelAdminLte\Menu\Builder;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function transform($item, Builder $builder)
    {
        if (!$this->isVisible($item)) {
            return false;
        }

        return $item;
    }

    protected function isVisible($item)
    {
        if (!isset($item['role'])) {
            return true;
        }

        return Auth::user()->hasRole($item['role']);
    }
}
