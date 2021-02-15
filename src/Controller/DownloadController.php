<?php

namespace App\Controller;

use App\Entity\Picture;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class DownloadController extends AbstractController
{
    public function picturesAllData()
    {
        $pictures = $this
            ->getDoctrine()
            ->getRepository(Picture::class)
            ->findAll();

        $ary = [];
        $pictureDetails = [];
        /** @var Picture[] $pictures */
        foreach($pictures as $picture) {
            $pictureDetails['id'] = $picture->getId();
            $pictureDetails['title'] = trim($picture->getTitle());
            $pictureDetails['url'] = trim($picture->getUrl());
            $pictureDetails['description'] = trim($picture->getDescription());
            $ary[] = $pictureDetails;
        }
        return new JsonResponse($ary);
    }

    public function pictureDetails($id)
    {
        $picture = $this
            ->getDoctrine()
            ->getRepository(Picture::class)
            ->findOneBy(["id" => $id]);

        if ($picture) {
            $pictureDetails = [];
            $pictureDetails['id'] = $picture->getId();
            $pictureDetails['title'] = trim($picture->getTitle());
            $pictureDetails['url'] = trim($picture->getUrl());
            $pictureDetails['description'] = trim($picture->getDescription());

            return new JsonResponse($pictureDetails);
        }
        else {
            return new JsonResponse(['message' => 'Resource not found']);
        }
    }

    public function pictureFile($id)
    {
        $picture = $this
            ->getDoctrine()
            ->getRepository(Picture::class)
            ->findOneBy(["id" => $id]);

        if ($picture) {
            $ary = explode('/', trim($picture->getUrl()));
            $file = __DIR__.'/../storage/'.end($ary);
            return new BinaryFileResponse($file);
        }
        else {
            return new JsonResponse(['message' => 'Resource not found']);
        }
    }
}