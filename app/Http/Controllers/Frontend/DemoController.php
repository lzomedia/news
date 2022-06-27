<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\View\View;

class DemoController extends FrontendController
{
    public function index(): View
    {
        return view('demo');
    }
}
