<?php

namespace App\Tests\Util;

use App\Util\ImageClient;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\CurlHttpClient;

class ImageClientTest extends TestCase
{
    // too risky depends on the outside, helpful for developing tough
    /*
    public function testFetchImageFromTheCloud()
    {
        $client = new CurlHttpClient();
        $url = 'https://c3.staticflickr.com/8/7350/10643721146_1a48c13161_c.jpg';
        $imageClient = new ImageClient($client);
        $imageClient->fetchImage($url);
        // check it was stored
        $urlExploded = explode('/', $url);
        $imageName = end($urlExploded);
        $this->assertTrue(file_exists(__DIR__.'/../../src/storage/'.$imageName));
    }
    */
}
