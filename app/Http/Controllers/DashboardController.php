<?php

namespace App\Http\Controllers;

use App\Contracts\FeedContract;
use App\Contracts\UserContract;
use App\Traits\UserErrorTrait;

class DashboardController extends Controller
{
    use UserErrorTrait;

    private FeedContract $feedDatabaseContract;

    private UserContract $userContract;

    public function __construct(
        FeedContract $feedDatabaseContract,
        UserContract $userContract
    ) {
        $this->feedDatabaseContract = $feedDatabaseContract;
        $this->userContract = $userContract;
        $this->middleware('auth');
    }


    public function dashboard(): \Illuminate\View\View
    {
        $feeds = $this->feedDatabaseContract->getAllFeeds(
            $this->userContract
        );

        return view('dashboard', compact('feeds'));
    }
}
