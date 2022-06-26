<?php

namespace App\Http\Controllers;

use App\Contracts\TextRewriterContract;
use App\Contracts\VideoContract;
use App\Jobs\RewriteArticle;
use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class TextRewriterController extends Controller
{
    private TextRewriterContract $textContract;

    public function __construct(TextRewriterContract $textContract)
    {
        $this->textContract = $textContract;
    }

    public function process(Article $article): RedirectResponse
    {
      $this->dispatch(new RewriteArticle($this->textContract, $article));

      Session::flash('success', 'Article has been queued for processing');

      return redirect('dashboard/articles');
    }
}
