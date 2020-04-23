<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Userapicontroller extends Controller
{
    public function AuthRouteAPI(Request $request){
        return $request->user();
    }
}
