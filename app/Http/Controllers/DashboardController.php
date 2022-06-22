<?php

namespace App\Http\Controllers;

use App\Contracts\FeedDatabaseContract;
use App\Traits\UserErrorTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{

    use UserErrorTrait;

    private FeedDatabaseContract $feedDatabaseContract;



    public function __construct(FeedDatabaseContract $feedDatabaseContract)
    {
        $this->feedDatabaseContract = $feedDatabaseContract;
    }


    public function dashboard(): \Illuminate\View\View
    {
        $user = Auth::user();

        $feeds = $this->feedDatabaseContract->getAllFeeds($user);

        return view('dashboard', compact ('feeds'));
    }
}
