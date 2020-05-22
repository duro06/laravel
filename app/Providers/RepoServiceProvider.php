<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\MemberRepo;
use App\Repositories\UserRepo;

class RepoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app::bind(MemberRepo);
        $this->app::bind(UserRepo);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
