<?php

namespace App\Http\Controllers;


use App\Contracts\ArticleDatabaseContract;
use App\Contracts\FeedDatabaseContract;

use App\Contracts\SyncContract;
use App\Enums\FeedStatus;
use App\Factories\ExtractorFactory;
use App\Models\Feed;
use App\Models\User;
use App\Parsers\OpmlParser;
use App\Requests\SaveFileRequest;
use App\Traits\UserErrorTrait;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class FeedsController extends Controller
{

    use UserErrorTrait;

    private FeedDatabaseContract $feedDatabaseContract;

    private SyncContract $syncContract;

    public function __construct(
        FeedDatabaseContract $feedDatabaseContract,
        SyncContract $syncContract
    )
    {


        $this->feedDatabaseContract = $feedDatabaseContract;

        $this->syncContract = $syncContract;


    }

    public function syncSingle(Feed $feed): RedirectResponse
    {

        $user = Auth::user();

        Session::flash('status', 'Feeds sync started successfully');

        $this->syncContract->syncSingle($feed, $user);

        return redirect('dashboard');
    }

    public function syncAll(): RedirectResponse
    {

        $user = Auth::user();

        $this->syncContract->syncAll($user);

        Session::flash('status', 'Feeds sync started successfully');

        return redirect('dashboard');
    }

    public function import( SaveFileRequest $request): RedirectResponse
    {



        //todo improve this
        $request->validated();

        $request->file('file')?->store('public');

        $parser = new OpmlParser();

        $localFile = Storage::get(('public/'.$request->file('file')?->hashName()));

        $parser->ParseOPML($localFile);

        $collection = (collect($parser->getContents()));

        $collection->each(function($data, $index)
        {
            if(array_key_exists('xmlurl', $data)  || array_key_exists('xmlUrl', $data))
            {
                try {


                    $feed = $this->feedDatabaseContract->createFeed([
                        'title' => $data['title'] ?? 'Title' . $index,
                        'url' => $data['xmlurl'] ?? $data['xmlUrl'],
                        'status' => Feed::INITIAL,
                        'user_id' => $user->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                    $this->syncContract->syncSingle($feed, $user);
                }
                catch (\Exception $e)
                {
                    Session::flash('status', 'Error while importing feeds');
                }
            }

        });


        Session::flash('status', 'Feeds imported successfully');

        return redirect('dashboard');
    }

}
