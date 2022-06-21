<?php

namespace App\Http\Controllers;

use App\Contracts\FeedDatabaseContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{

    private FeedDatabaseContract $feedDatabaseContract;

    public function __construct(FeedDatabaseContract $feedDatabaseContract)
    {
        $this->middleware('auth');
        $this->feedDatabaseContract = $feedDatabaseContract;
    }


    public function dashboard(): \Illuminate\View\View
    {
        $feeds = $this->feedDatabaseContract->getAllFeeds();

        return view('dashboard', compact ('feeds'));
    }
}
