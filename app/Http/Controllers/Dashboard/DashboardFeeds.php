<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\FeedContract;
use App\Contracts\SyncContract;
use App\Contracts\UserContract;
use App\Models\Feed;
use App\Parsers\OpmlParser;
use App\Requests\SaveFileRequest;
use App\Tables\FeedsTable;
use App\Traits\UserErrorTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DashboardFeeds extends Controller
{
    use UserErrorTrait;

    private FeedContract $feedDatabaseContract;

    private SyncContract $syncContract;

    private UserContract $userContract;

    private string $redirectTo = 'dashboard/feeds';

    public function __construct(
        FeedContract $feedDatabaseContract,
        SyncContract $syncContract,
        UserContract $userContract
    ) {
        $this->feedDatabaseContract = $feedDatabaseContract;

        $this->syncContract = $syncContract;

        $this->userContract = $userContract;
        $this->middleware('auth');
    }

    public function index(FeedsTable $feedsTable)
    {
        return $feedsTable->render('dashboard.feeds');
    }

    public function syncSingle(Feed $feed): RedirectResponse
    {
        Session::flash('status', 'Feeds sync started successfully');

        $this->syncContract->syncSingle($feed->id, $this->userContract->getUserId());

        return redirect($this->redirectTo);
    }

    public function syncAll(): RedirectResponse
    {
        $true = $this->syncContract->syncAll($this->userContract);

        if (!$true) {
            Session::flash('status', 'Feeds sync failed');
        }

        Session::flash('status', 'Feeds sync started successfully');

        return redirect($this->redirectTo);
    }

    public function import(SaveFileRequest $request): RedirectResponse
    {
        //todo improve this
        $request->validated();

        $request->file('file')?->store('public');

        $parser = new OpmlParser();

        $localFile = Storage::get(('public/'.$request->file('file')?->hashName()));

        $parser->ParseOPML($localFile);

        $collection = (collect($parser->getContents()));

        $collection->each(
            function ($data, $index) {
                if (array_key_exists('xmlurl', $data)  || array_key_exists('xmlUrl', $data)) {
                    try {
                        $feed = $this->feedDatabaseContract->createFeed(
                            [
                                'title' => $data['title'] ?? 'Title' . $index,
                                'url' => $data['xmlurl'] ?? $data['xmlUrl'],
                                'status' => Feed::INITIAL,
                                'user_id' => $this->userContract->getUserId()
                            ]
                        );

                        $userID = $this->userContract->getUserId();

                        $feedID = $feed->id;

                        $this->syncContract->syncSingle($feedID, $userID);
                    } catch (\Exception $e) {
                        Session::flash('status', 'Error while importing feeds');
                    }
                }
            }
        );


        Session::flash('status', 'Feeds imported successfully');

        return redirect($this->redirectTo);
    }


    public function find(): View
    {
        return view('dashboard.feeds-find');
    }
}
