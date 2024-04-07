<?php
// src/Service/FileUploaderService.php
namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploaderService
{
    private $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    public function upload(UploadedFile $file): string
    {
        $uploadsDir = $this->parameterBag->get('uploads_dir');
        $filename = sprintf("%s.%s", md5(uniqid()), $file->guessClientExtension());

        $file->move($uploadsDir, $filename);

        return $filename;
    }
}
