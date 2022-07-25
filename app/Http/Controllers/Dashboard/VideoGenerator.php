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

}
