<?php

namespace App\Http\Controllers;

use App\Traits\UserErrorTrait;

class DashboardController extends Controller
{
    use UserErrorTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function dashboard(): \Illuminate\View\View
    {
        return view('dashboard');
    }
}
