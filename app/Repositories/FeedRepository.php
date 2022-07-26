<?php

namespace App\Repositories;

use App\Contracts\FeedContract;
use App\Contracts\SyncContract;
use App\Contracts\UserContract;
use App\Models\Feed;
use App\Parsers\OpmlParser;
use App\Requests\SaveFileRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class FeedRepository implements FeedContract
{
    protected syncContract $syncContract;
    protected userContract $userContract;
    protected feedContract $feedDatabaseContract;
    private string $redirectTo = 'dashboard/feeds';

    public function __construct(
        syncContract $syncContract,
        userContract $userContract,
        feedContract $feedDatabaseContract
    ) {
        $this->syncContract = $syncContract;
        $this->userContract = $userContract;
        $this->feedDatabaseContract = $feedDatabaseContract;
    }

    public function getFeedById(int $feedId): mixed
    {
        return Feed::find($feedId);
    }

    public function getAllFeeds(UserContract $userContract): Collection
    {
        return Feed::where('user_id', $userContract->getUserId())->get();
    }

    public function deleteFeed(Feed | Model $feed): bool
    {
        return $feed->delete();
    }

    public function createFeed(array $feed): mixed
    {
        return Feed::firstOrCreate($feed);
    }

    public function getFeedsForUser(UserContract $userContract): Collection
    {
        return Feed::where('user_id', $userContract->getUserId())->get();
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

}
