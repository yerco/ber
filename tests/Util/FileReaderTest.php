<?php

namespace App\Tests\Util;

use App\Util\FileReader;
use PHPUnit\Framework\TestCase;

class FileReaderTest extends TestCase
{
    const FILENAME = __DIR__ . '/../images_data.csv';

    public function testReadRowsAtFileReader()
    {
        $fileReader = new FileReader(self::FILENAME);
        $rows = $fileReader->usefulLines();
        $counter = 0;
        foreach($rows as $row) {
            $counter++;
        }
        $fileReader->close();
        // 6 are the valid lines of the testing file
        $this->assertEquals(6, $counter);
    }
}
