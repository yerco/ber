<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DownloadControllerTest extends WebTestCase
{
    // testing only 200 because depends on information at the test DB
    public function testAllPictureData()
    {
        $client = static::createClient();
        $client->request('GET', '/picturesalldata');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testGetPictureDetailsJson()
    {
        $client = static::createClient();
        $client->request('GET', '/picturedetails/100000000000000000');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $response = json_decode($client->getResponse()->getContent());
        $this->assertEquals('Resource not found', $response->message);
    }

    public function testPictureFile()
    {
        $client = static::createClient();
        $client->request('GET', '/picturefile/1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
