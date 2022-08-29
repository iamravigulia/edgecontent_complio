<?php

namespace edgewizz\Edgecontent;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class EdgecontentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Edgewizz\Edgecontent\Controllers\FormatController');
        $this->app->make('Edgewizz\Edgecontent\Controllers\ProblemSetController');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // dd($this);
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__ . '/components', 'format');
        $this->loadViewsFrom(__DIR__ . '/components', 'problem_set');
        $this->loadViewsFrom(__DIR__ . '/components', 'problem');
        Blade::component('format::format.create', 'format.create');
        Blade::component('format::format.edit', 'format.edit');
        Blade::component('format::format.index', 'format.index');
        Blade::component('problem_set::problem_set.create', 'problem_set.create');
        Blade::component('problem_set::problem_set.addmore', 'problem_set.addmore');
        Blade::component('problem_set::problem_set.index', 'problem_set.index');
        // 
        Blade::component('problem::problem.create', 'problem.create');
        Blade::component('problem::problem.index', 'problem.index');
        Blade::component('problem::problem.edit', 'problem.edit');
        Blade::component('problem::problem.addques', 'problem.addques');
        Blade::component('problem::problem.format', 'problem.format');
        Blade::component('problem::problem.setindex', 'problem.setindex');
        Blade::component('problem::problem.que_edit', 'problem.que_edit');
        Blade::component('problem::problem.move_set', 'problem.move_set');
        Blade::component('problem::problem.sequence', 'problem.sequence');
    }
}
