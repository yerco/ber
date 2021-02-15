<?php

namespace App\Util;

use App\Entity\Picture;
use Doctrine\ORM\EntityManagerInterface;

class DbHandler
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function dbPersist($contents)
    {
        foreach($contents->usefulLines() as $content) {
            $picture = new Picture();
            $picture->setTitle($content[0]);
            $picture->setUrl($content[1]);
            $picture->setDescription($content[2]);

            // does this picture already exists?
            /** @var Picture $ePicture */
            $ePicture = $this->entityManager
                ->getRepository(Picture::class)
                ->findBy(['title' => $content[0]]);
            if ($ePicture) {
                $ePicture[0]->setTitle($content[0]);
                $ePicture[0]->setUrl($content[1]);
                $ePicture[0]->setDescription($content[2]);
                $this->entityManager->persist($ePicture[0]);
                $this->entityManager->flush();
                continue;
            }

            $this->entityManager->persist($picture);
        }
        $this->entityManager->flush();
        $contents->close();
    }
}