<?php

namespace App\Parsers;

class OpmlParser implements \Iterator
{
    protected $parser = null;


    protected $position = 0;

    public $opml_contents = [];

    protected $unparsed_opml = '';

    protected $opml_map_vars = array(
        'ID' => 'id', // Unique element ID
        'TYPE' => 'type', // Element type (audio, feed, playlist, etc)
        'URL' => 'url', // Location of the item. Depending on the value of the type attribute, this can be either a single audio stream or audio playlist, a remote OPML file containing a playlist of audio items, or a remote OPML file to browse.
        'HTMLURL' => 'html_url', // Top-level link element
        'TEXT' => 'title', // Specifies the title of the item.
        'TITLE' => 'title', // Specifies the title of the item.
        'LANGUAGE' => 'language', // The value of the top-level language element
        'TARGET' => 'link_target', // The target window of the link
        'VERSION' => 'version', // Varies depending on the version of RSS that's being supplied. RSS1 for RSS 1.0; RSS for 0.91, 0.92 or 2.0; scriptingNews for scriptingNews format. There are no known values for Atom feeds, but they certainly could be provided.
        'DESCRIPTION' => 'description', // The top-level description element from the feed.
        'XMLURL' => 'xml_url', // The http address of the feed
        'CREATED' => 'created', // Date-time that the outline node was created
        'IMAGEHREF' => 'imageHref', // A link to an image related to the element (.e.g. a song poster)
        'ICON' => 'icon', // A link to an icon related to the element (.e.g. a radio-station's icon)
        'F' => 'song', // When used in OPML playlists, it's used to specify the song's filename.
        'BITRATE' => 'bitrate', // Used to specify the bitrate of an audio stream, in kbps.
        'MIME' => 'mime', //  Enter the MIME type of the stream/file.
        'DURATION' => 'duration', // If the item is not a live radio stream, set duration to the playback duration in seconds to ensure the progress bar is displayed correctly. This is especially helpful for VBR files where our bitrate detection may not work properly.
        'LISTENERS' => 'listeners', // Used to display the number of listeners currently listening to an audio stream.
        'CURRENT_TRACK' => 'current_track', // Used to display the track that was most recently playing on a radio station.
        'GENRE' => 'genre', //The genre of a stream may be specified with this attribute.
        'SOURCE' => 'source', // The source of the audio. This is currently used to describe, for instance, how a concert was recorded.
    );

    public function __construct()
    {
        $this->parser = null;
        $this->opml_contents = [];
        $this->position = 0;
    }

    public function rewind()
    {
        $this->position = 0;
    }


    public function current()
    {
        return $this->opml_contents[$this->position];
    }

    public function key()
    {
        return $this->position;
    }


    public function next()
    {
        ++$this->position;
    }

    public function valid()
    {
        return isset($this->opml_contents[$this->position]);
    }

    protected function getOPMLFile($location = '', $context = null)
    {
        if (in_array('curl', get_loaded_extensions())) {
            $options = array(
                CURLOPT_RETURNTRANSFER => true, // return web page
                CURLOPT_HEADER => false, // don't return headers
                CURLOPT_FOLLOWLOCATION => true, // follow redirects
                CURLOPT_MAXREDIRS => 10, // stop after 10 redirects
                CURLOPT_ENCODING => "", // handle compressed
                CURLOPT_USERAGENT => "test", // name of client
                CURLOPT_AUTOREFERER => true, // set referrer on redirect
                CURLOPT_CONNECTTIMEOUT => 120, // time-out on connect
                CURLOPT_TIMEOUT => 120, // time-out on response
            );

            $ch = curl_init($location);
            curl_setopt_array($ch, $options);
            $contents = curl_exec($ch);
        } else {
            $contents = file_get_contents($location, false, $context);
        }
        return $contents;
    }

    protected function ParseElementStart($parser, $tagName, $attrs)
    {
        $map = $this->opml_map_vars;

        // Parse attributes if entered an "outline" tag
        if ($tagName === 'OUTLINE') {
            $node = [];

            foreach (array_keys($this->opml_map_vars) as $key) {
                if (isset($attrs[$key])) {
                    $node[strtolower($key)] = $attrs[$key];
                }
            }

            $this->opml_contents[] = $node;
        }
    }


    protected function ParseElementEnd($parser, $tagName)
    {
        // nothing to do.
    }

    protected function ParseElementCharData($parser, $data)
    {
        // nothing to do.
    }

    protected function Parser($XMLdata): void
    {
        // Reset iterator
        $this->position = 0;

        $this->parser = xml_parser_create();

        xml_set_object($this->parser, $this);

        xml_set_element_handler($this->parser, array(&$this, 'ParseElementStart'), array(&$this, 'ParseElementEnd'));

        xml_set_character_data_handler($this->parser, array(&$this, 'ParseElementCharData'));

        xml_parse($this->parser, $XMLdata);

        xml_parser_free($this->parser);
    }

    public function ParseLocation($location, $context = null): void
    {
        $this->unparsed_opml = trim($this->getOPMLFile($location, $context));
        $this->Parser($this->unparsed_opml);
    }

    public function ParseOPML($opml): void
    {
        $this->unparsed_opml = trim($opml);
        $this->Parser($this->unparsed_opml);
    }

    final public function getUnparsedOPML(): string
    {
        return $this->unparsed_opml;
    }

    final public function setAttribute($attribute, $mapped_attribute = ''): void
    {
        $attribute = strtoupper(preg_replace('/\s+/', '_', trim($attribute)));
        if ($mapped_attribute !== '') {
            $mapped_attribute = strtoupper(preg_replace('/\s+/', '_', trim($mapped_attribute)));
        } else {
            $mapped_attribute = strtolower($attribute);
        }

        $this->opml_map_vars[$attribute] = $mapped_attribute;
    }


    final public function unsetAttribute($attribute): void
    {
        $attribute = strtoupper(preg_replace('/\s+/', '_', trim($attribute)));

        unset($this->opml_map_vars[$attribute]);
    }

    /**
     * @return array
     */
    final public function getContents(): array
    {
        return $this->opml_contents;
    }
}
