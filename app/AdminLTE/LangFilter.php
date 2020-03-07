<?php

namespace App\AdminLTE;

use JeroenNoten\LaravelAdminLte\Menu\Builder;

class LangFilter extends \JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter
{
    public function transform($item, Builder $builder)
    {
        if (isset($item['header'])) {
            $item['header'] = $this->getTranslation($item['header']) ?? $item['header'];
        }
        if (isset($item['text'])) {
            $item['text'] = $this->getTranslation($item['text']) ?? $item['text'];
        }

        return $item;
    }

    protected function getTranslation($item)
    {
        if ($this->langGenerator->has("menu.{$item}")) {
            return $this->langGenerator->get("menu.{$item}");
        } elseif ($this->langGenerator->has("adminlte::menu.{$item}")) {
            return $this->langGenerator->get("adminlte::menu.{$item}");
        }

        return $item;
    }
}
