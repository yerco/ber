<?php

namespace App\Util;


class FileReader
{
    // resources cannot be type hinted
    private $filename;

    public function __construct(string $filename)
    {
        $this->filename = fopen($filename, 'r');
    }

    public function usefulLines(): \Generator
    {
        if ($this->filename !== false) {
            // assuming 1000 characters is enough
            while (($line = fgetcsv($this->filename, 1000, '|')) !== false) {
                if ($line[0] === null) continue;
                if (isset($line[1])) {
                    if (preg_match('/http[s]:\/\/[a-zA-Z0-9]+/', $line[1]))
                        yield $line;
                }
            }
        }
    }

    public function close() {
        fclose($this->filename);
    }
}