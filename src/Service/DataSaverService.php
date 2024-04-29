<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class DataSaverService
{
    private $filesystem;
    private $targetDirectory;

    public function __construct(Filesystem $filesystem, string $targetDirectory)
    {
        $this->filesystem = $filesystem;
        $this->targetDirectory = $targetDirectory;
    }

    public function saveDataToFile(array $data, string $filename): void
    {
        $jsonData = json_encode($data);

        try {
            // Ensure the target directory exists
            $this->filesystem->mkdir($this->targetDirectory);

            // Save the file
            $this->filesystem->dumpFile($this->targetDirectory . '/' . $filename, $jsonData);
        } catch (IOExceptionInterface $exception) {
            throw new \Exception("An error occurred while writing to the file at " . $exception->getPath());
        }
    }
}
