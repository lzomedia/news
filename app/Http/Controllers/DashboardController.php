<?php

namespace App\Http\Controllers;

use App\Contracts\FeedDatabaseContract;
use App\Contracts\UserContract;
use App\Traits\UserErrorTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{

    use UserErrorTrait;

    private FeedDatabaseContract $feedDatabaseContract;

    private UserContract $userContract;

    public function __construct(
        FeedDatabaseContract $feedDatabaseContract,
        UserContract $userContract
    )
    {
        $this->feedDatabaseContract = $feedDatabaseContract;
        $this->userContract = $userContract;
    }


    public function dashboard(): \Illuminate\View\View
    {

        $feeds = $this->feedDatabaseContract->getAllFeeds(
            $this->userContract->getUser()
        );

        return view('dashboard', compact ('feeds'));
    }


    public function articles(Request $request)
    {
        return view('dashboard.articles');
    }
}
