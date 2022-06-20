<?php

namespace App\Http\Controllers;

use App\Contracts\FeedDatabaseContract;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    private FeedDatabaseContract $feedDatabaseContract;

    public function __construct(FeedDatabaseContract $feedDatabaseContract)
    {
        $this->middleware('auth');
        $this->feedDatabaseContract = $feedDatabaseContract;
    }


    public function home()
    {
        $feeds = $this->feedDatabaseContract->getAllFeeds();

        return view('home', compact ('feeds'));
    }
}
