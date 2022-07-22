
<?=
'<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<rss version="2.0">
    <channel>
        <title><![CDATA[ Development.sh ]]></title>
        <link><![CDATA[ https://example.com/feed ]]></link>
        <description><![CDATA[ Development.sh is an ai-powered news reader that pulls in and dissects the content of your favorite news channels. It then provides you with a personalized article feed based on your interests. ! ]]></description>
        <language>en</language>
        <pubDate>{{ now()->toDayDateTimeString('Asia/Dhaka') }}</pubDate>

        @foreach($articles as $article)
            <item>
                <title><![CDATA[{{ $article->title }}]]></title>
                <link>{{ url('/') }}/articles/{{ $article->id }}/{{ Str::slug($article->title) }}</link>
                <description><![CDATA[{!! $article->summary !!}]]></description>
                <category>{{ $article->category->name }}</category>
                <author><![CDATA[{{ $article->author  }}]]></author>
                <guid>{{ $article->id }}</guid>
                <pubDate>{{ $article->created_at->toRssString() }}</pubDate>
            </item>
        @endforeach
    </channel>
</rss>
