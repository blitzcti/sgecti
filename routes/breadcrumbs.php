<?php

use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

/*
|--------------------------------------------------------------------------
| Breadcrumbs
|--------------------------------------------------------------------------
|
| Here is where you can register Breadcrumbs for your application.
|
*/

Breadcrumbs::register('home', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('Home', route('home'));
});
