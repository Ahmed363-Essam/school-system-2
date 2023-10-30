<?php

namespace App\Providers;


use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail2;
use Illuminate\Support\ServiceProvider;

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
     * @return void
     */
    public function boot()
    {
       User::created(function($user)
        {
            Mail::to($user)->send(new TestMail2($user));
        });

        User::updated(function($user)
        {
            Mail::to($user)->send(new TestMail2($user));
        });
    }
}
