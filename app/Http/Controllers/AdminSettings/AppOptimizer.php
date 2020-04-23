<?php

namespace App\Http\Controllers\AdminSettings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class AppOptimizer extends Controller
{
    public function appBooter(Request $request){
        if($request->ajax()){
                //reset config
                Artisan::call('route:clear');
                Artisan::call('config:clear');
                Artisan::call('view:clear');
                Artisan::call('cache:clear');

                // reconfig
                Artisan::call('config:cache');
                Artisan::call('route:cache');
                Artisan::call('optimize');
                echo 1;
        }
    }
    public function booterapp(){
                //reset config
                Artisan::call('route:clear');
                Artisan::call('config:clear');
                Artisan::call('view:clear');
                Artisan::call('cache:clear');

                // reconfig
                Artisan::call('config:cache');
                Artisan::call('route:cache');
                Artisan::call('optimize');
                return "optimize.....";
    }
    
}
