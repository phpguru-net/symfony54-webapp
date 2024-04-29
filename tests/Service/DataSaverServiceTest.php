<?php

namespace App\Tests\Service;

use App\Service\DataSaverService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

class DataSaverServiceTest extends TestCase
{
    private $targetDirectory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->targetDirectory = sys_get_temp_dir(); // Use system temp directory for testing
        $this->service = new DataSaverService(new Filesystem(), $this->targetDirectory);
    }

    protected function tearDown(): void
    {
        // Cleanup: Remove any files created during tests
        $filesystem = new Filesystem();
        $filesystem->remove($this->targetDirectory . '/test_posts.json');
    }

    public function testSaveDataToFile()
    {
        $data = [
            ['id' => 1, 'title' => 'Test Post', 'content' => 'This is a test post']
        ];
        $filename = 'test_posts.json';
        $this->service->saveDataToFile($data, $filename);

        $expectedPath = $this->targetDirectory . '/' . $filename;
        $this->assertFileExists($expectedPath);
        $content = file_get_contents($expectedPath);
        $this->assertEquals(json_encode($data), $content);
    }

    public function testWriteFailure()
    {
        $filesystemMock = $this->createMock(Filesystem::class);
        $filesystemMock->method('dumpFile')
            ->will($this->throwException(new \Exception("Failed to write file")));

        $service = new DataSaverService($filesystemMock, $this->targetDirectory);
        $this->expectException(\Exception::class);
        $service->saveDataToFile([], 'test_fail.json');
    }

}
