<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Event;
use App\UserEvent;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //for database issue
        schema::defaultStringLength(191);
        //partial views with thier own data
        view()->composer('layout.notifications',function($view){
            
            $count=UserEvent::where('user_id',auth()->id())->count();
            
            $events=Event::orderBy('created_at','desc')->limit(10)->get();
            $view->with(['events'=>$events,'count'=>$count]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
