<?php

namespace App\Http\Controllers;


use App\Contracts\ArticleDatabaseContract;
use App\Contracts\FeedDatabaseContract;

use App\Contracts\SyncContract;
use App\Models\Feed;
use App\Parsers\OpmlParser;
use App\Requests\SaveFileRequest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class FeedsController extends Controller
{

    private FeedDatabaseContract $feedDatabaseContract;

    private SyncContract $syncContract;

    public function __construct(
        FeedDatabaseContract $feedDatabaseContract,
        SyncContract $syncContract
    )
    {
        $this->middleware('auth');
        $this->feedDatabaseContract = $feedDatabaseContract;
        $this->syncContract = $syncContract;
    }

    public function syncSingle(Feed $feed): RedirectResponse
    {

        $this->syncContract->syncSingle($feed);

        Session::flash('status', 'Feeds sync started successfully');

        return redirect('home');
    }

    public function syncAll(): RedirectResponse
    {
        $this->syncContract->syncAll();

        Session::flash('status', 'Feeds sync started successfully');

        return redirect('home');
    }

    public function import( SaveFileRequest $request): RedirectResponse
    {

        $request->validated();

        $request->file('file')?->store('public');

        $parser = new OpmlParser();

        $localFile = Storage::get(('public/'.$request->file('file')?->hashName()));

        $parser->ParseOPML($localFile);

        $collection = (collect($parser->getContents()));

        $collection->each(function($data)
        {

            $normLink = strtolower('xmlUrl');

            $item = [
                'user_id' => auth()->user()->id,
                'title' => $data['text'],
                'url' => $data[$normLink],
            ];

            $feed = $this->feedDatabaseContract->createFeed($item);

            $this->syncSingle($feed);

        });


        Session::flash('status', 'Feeds imported successfully');

        return redirect('home');
    }

}
