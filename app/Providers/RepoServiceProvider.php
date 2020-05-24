<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\MemberRepo;
use App\Repositories\UserRepo;
use App\Repositories\HakAnggotaRepo;

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
        $this->app::bind(HakAnggotaRepo);
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
