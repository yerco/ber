<?php

namespace App\Tests\Controller;

use App\Entity\Picture;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadControllerTest extends WebTestCase
{
    /** @var \Doctrine\ORM\EntityManager */
    private $entityManager;
    /** @var \Symfony\Bundle\FrameworkBundle\KernelBrowser */
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testUploadCSVFileIsPersistedToDatabase()
    {
        $csvFile =  new UploadedFile(
            __DIR__.'/../images_data.csv',
            'images_data.csv',
            'text/csv',
            null
        );
        $this->client->request(
            'POST',
            '/upload',
            [],
            ['file' => $csvFile],
            [],
            '{"author":"Fabien"}'
        );

        /** @var Picture $picture */
        $picture = $this->entityManager
            ->getRepository(Picture::class)
            ->findOneBy(['title' => 'City 1'])
        ;
        $this->assertEquals(" City in the night", $picture->getDescription());
    }
}