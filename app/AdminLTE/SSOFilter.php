<?php

namespace App\AdminLTE;

use JeroenNoten\LaravelAdminLte\Menu\Builder;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class SSOFilter implements FilterInterface
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
        if (!isset($item['sso'])) {
            return true;
        }

        return $item['sso'] == config('broker.useSSO');
    }
}
