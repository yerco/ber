<?php


namespace App\Controller;

use App\Util\DbHandler;
use App\Util\FileReader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UploadController
{
    private DbHandler $dbHandler;

    public function __construct(DbHandler $dbHandler)
    {
        $this->dbHandler = $dbHandler;
    }

    // to be used directly, see note in method below
    public function upload(Request $request)
    {
        $file = $request->files->get('file');
        if (is_null($file))
            return new Response("file not sent");
        $contents = new FileReader($file);
        $this->dbHandler->dbPersist($contents);

        return new Response('Records saved');
    }

    // requests using cUrl
    //Note: for some reason my cUrl does upload csv files immediately
    public function curlUpload(Request $request)
    {
        $myfile = fopen(__DIR__."/postedfile.txt", "w") or die("Unable to open file!");
        fwrite($myfile, $request->getContent());
        $contents = new FileReader(__DIR__."/postedfile.txt");
        $this->dbHandler->dbPersist($contents);

        return new Response('Records saved');
    }
}