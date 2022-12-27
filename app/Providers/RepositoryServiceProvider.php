<?php

namespace App\Providers;

use App\Repositories\BaseRepository;
use App\Repositories\RepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(RepositoryInterface::class, BaseRepository::class);
    }
}
