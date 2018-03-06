<?php

declare(strict_types = 1);

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class FileAwareEntity
 */
trait FileAwareEntity
{
    /**
     * @var string
     * @ORM\Column(name="file", type="string", length=18, nullable=true)
     */
    protected $fileName;

    /**
     * @var string
     * @ORM\Column(name="file_mimetype", type="string", length=127, nullable=true)
     */
    protected $mimeType;

    /**
     * @var string
     */
    protected $fileContent;

    /**
     * @return string|null
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @return string|null
     */
    public function getFileContent()
    {
        return $this->fileContent;
    }

    /**
     * @param string|null $filename
     */
    public function setFileName(string $filename=null)
    {
        $this->fileName = $filename;
    }

    /**
     * @return string|null
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @param string|null $type
     */
    public function setMimeType(string $type=null)
    {
        $this->mimeType = $type;
    }

    /**
     * @param string|null $fileContent
     */
    public function setFileContent(string $fileContent=null)
    {
        $this->fileContent = $fileContent;
    }
}
