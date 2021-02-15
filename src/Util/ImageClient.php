<?php

namespace App\Util;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ImageClient
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function fetchImage($url)
    {
        $ary = explode("/", $url);
        $imageName = end($ary);
        $content = file_get_contents($url);

        //Store in the filesystem.
        $fp = fopen(__DIR__."/../storage/".$imageName, "w");
        fwrite($fp, $content);
        fclose($fp);
    }
}
