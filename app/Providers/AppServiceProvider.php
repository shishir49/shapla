<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Showroom;
use Session;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        Schema::defaultStringLength(191);

        View::composer('*', function ($view){

          if(Session::get('admin_session')){
             $data['suppliers'] = User::where('role',3)->where('status',1)->get();
             $data['categories'] = Category::where('status',1)->get();
             $data['warehouses'] = Warehouse::where('status',1)->get();
             $data['showrooms'] = Showroom::where('status',1)->get();
             $data['products'] = Product::where('status',1)->get();
             $view->with($data);
            }
        });  
    }
}
