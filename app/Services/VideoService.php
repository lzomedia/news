<?php

namespace App\Services;

use Alaouy\Youtube\Youtube;
use App\Contracts\VideoContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Process\Process;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class VideoService implements VideoContract
{
    protected HttpClientInterface $client;

    private const TTS = 'python3';

    private const OPTION = '--text';


    public function __construct()
    {
        $this->client = HttpClient::create([]);
    }

    /**
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function find(string $query): Collection
    {
        try
        {
            $content = collect([]);

            $key = config('youtube.key');
            $videoList = (new \Alaouy\Youtube\Youtube($key))->search($query);

            $content->push($videoList);

            return $content->flatten(1);

        }
        catch (\Exception $exception)
        {
            logger("There was an error with the youtube extraction {$exception->getMessage()}");
        }

        return collect([]);
    }

    public function generate(mixed $article): void
    {
        try {
            $process = new Process(
                [
                    self::TTS,
                    self::OPTION,
                    strip_tags($article->content),
                ]
            );
            $process->setTimeout(3600);


            $process->run(
                function ($type, $buffer) {
                    Log::error("Output: $buffer");
                }
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
