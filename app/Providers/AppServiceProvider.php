<?php

namespace App\Providers;

use App\Course;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

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

        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $courses = Course::all()->sortBy('id');
            $event->menu->add('CURSOS');

            foreach ($courses as $course) {
                if ($course->active) {
                    $event->menu->add([
                        'text' => $course->name,
                        'icon_color' => $course->color
                    ]);
                }
            }
        });
    }
}
