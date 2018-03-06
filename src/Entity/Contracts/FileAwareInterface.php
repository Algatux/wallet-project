<?php

declare(strict_types = 1);

namespace App\Entity\Contracts;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Interface FileAwareInterface
 */
interface FileAwareInterface
{
    /**
     * @return string|null
     */
    public function getFilename();

    /**
     * @return string|null
     */
    public function getFileContent();

    /**
     * @param string|null $filename
     */
    public function setFileName(string $filename=null);

    /**
     * @param string|null $fileContent
     */
    public function setFileContent(string $fileContent=null);

    /**
     * @return UploadedFile|null
     */
    public function getUploadedFile();

    /**
     * @param UploadedFile|null $uploadedFile
     */
    public function setUploadedFile(UploadedFile $uploadedFile=null);
}
