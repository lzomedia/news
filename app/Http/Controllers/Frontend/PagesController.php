<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\View\View;

class PagesController extends FrontendController
{
    public function index(): View
    {
        return view('pages.demo');
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function terms(): View
    {
        return view('pages.terms');
    }
}
