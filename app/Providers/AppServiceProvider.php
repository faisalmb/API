<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Webpatser\Uuid\Uuid;

class AppServiceProvider extends ServiceProvider
{
    // private $models = [
    //     '\App\branch',
        
    // ];

    // public function boot()
    // {
    //     foreach ($this->models as $modelClass)
    //     {
    //         $modelClass::creating(function($model) {
              
    //             if (!$model->id) {
    //                 $model->id = Uuid::generate()->string;
    //             }
                
    //         });
    //     }
    // }

    public function register()
    {

    }
}
