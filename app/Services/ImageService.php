<?php
namespace App\Services;


use App\Contracts\ImagesContract;
use Illuminate\Support\Collection;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ImageService implements ImagesContract
{
    private HttpClientInterface $client;

    public function __construct()
    {
        $this->client = HttpClient::create([]);
    }


    /**
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function getImages(string $query): Collection
    {

        $collection = collect();
        $collection->push($this->extractBing($query));
        $collection->push($this->extractImgur($query));
        $collection->push($this->extractYahoo($query));
        $collection->flatten(1);

        return $collection;
    }


    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    private function extractYahoo(string $query): array | bool
    {
        $response = $this->client->request('GET', config('images.yahoo.url') . $query);

        $crawler = new Crawler($response->getContent());

        $images = collect([]);

        $crawler->filter(config('images.yahoo.rules'))->each(function (Crawler $node, $i) use ($images) {
            $content = $node->attr('src');
            $content = str_replace('300', '750', $content);
            $images->push($content);
        });

        if ($images->count() > 0) {
            return $images->toArray();
        }
        return false;
    }
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    private function extractImgur(string $query): array | bool
    {
        $response = $this->client->request('GET', config('images.imgur.url') . $query);

        $crawler = new Crawler($response->getContent());

        $images = collect([]);

        $crawler->filter(config('images.imgur.rules'))->each(function (Crawler $node, $i) use ($images) {
            $content = $node->attr('src');
            $content = str_replace(array('b', "//"), array('', 'https://'), $content);
            $images->push($content);
        });

        if ($images->count() > 0) {
            return $images->toArray();
        }
        return false;
    }
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    private function extractBing(string $query): array | bool
    {
        $response = $this->client->request('GET', config('images.bing.url') . $query);

        $crawler = new Crawler($response->getContent());

        $images = collect([]);

        $crawler->filter(config('images.bing.rules'))->each(function (Crawler $node, $i) use ($images) {
            $content = $node->attr('src2');
            $content =  str_replace('42', '1920', $content);
            if($content !== ""){
                $images->push($content);
            }
        });

        if ($images->count() > 0) {
            return $images->toArray();
        }
        return false;
    }


}
