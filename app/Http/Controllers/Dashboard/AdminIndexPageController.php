<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminIndexPageController extends Controller
{
    public function index(){
        return view('DashBoard.dashboard-index');
    }
}
