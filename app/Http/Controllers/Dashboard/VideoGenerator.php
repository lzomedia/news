<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\VideoContract;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Feed;
use App\Parsers\OpmlParser;
use App\Requests\SaveFileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class VideoGenerator extends Controller
{
    private VideoContract $videoContract;

    public function __construct(VideoContract $videoContract)
    {
        $this->videoContract = $videoContract;
    }

    public function generate(Article $article): View
    {
        return view('dashboard.video-generate', [
            'article' => $article,
        ]);
    }

    public function upload(Article $article): void
    {
        Log::info('Uploading video for article: ' . $article->id);
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
