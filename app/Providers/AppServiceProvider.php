<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\RandomRepository;
use App\Repositories\Contracts\RandomRepositoryInterface;

use App\Repositories\FooAbstract;
use App\Repositories\FooConcrete1;
use App\Http\Controllers\Foo1;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RandomRepositoryInterface::class, RandomRepository::class);

        // bind using when/needs/give pattern
        // when controller Foo1 needs FooAbstract, give it a FooConcrete1
        // $this->app->when(Foo1::class)
        //           ->needs(FooAbstract::class)
        //           ->give(FooConcrete1::class);

        // same binding using 'bind' method
        $this->app->bind(FooAbstract::class, FooConcrete1::class);
    }
}
