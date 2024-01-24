<?php

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blueprint::macro('userstamps', function () {
            $this->unsignedBigInteger('created_by')->nullable();
            $this->unsignedBigInteger('updated_by')->nullable();
            $this->unsignedBigInteger('deleted_by')->nullable();
            $this->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $this->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $this->foreign('deleted_by')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
