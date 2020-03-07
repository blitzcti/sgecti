<?php

namespace App\Providers;

use App\Auth;
use App\Models\Course;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use JeroenNoten\LaravelAdminLte\Menu\Builder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @param Dispatcher $events
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        Schema::defaultStringLength(191);
        setlocale(LC_TIME, "{$this->app->getLocale()}.UTF8");

        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $this->loadMenu($event->menu);
        });
    }

    public function loadMenu(Builder $menu)
    {
        $courses = Course::actives()->orderBy('id')->get();
        $user = Auth::user();

        if ($user->isAdmin()) {
            //Cursos tab
            $menu->add('CURSOS');

            foreach ($courses as $course) {
                $color = $course->color;

                $menu->add([
                    'text' => $course->name,
                    'icon_color' => $color->name,
                    'url' => route('admin.curso.detalhes', $course->id),
                ]);
            }
        }
    }
}
