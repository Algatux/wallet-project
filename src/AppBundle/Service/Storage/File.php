<?php

declare(strict_types = 1);

namespace AppBundle\Service\Storage;

/**
 * Class File
 */
class File
{
    /**
     * @param string|null $extension
     *
     * @return string
     */
    public static function generateFileName(string $extension = null): string
    {
        $filename = uniqid();
        if (null !== $extension) {

            return sprintf("%s.%s", $filename, $extension);
        }

        return $filename;
    }

    /**
     * @param string $originalFileName
     *
     * @return string
     */
    public static function generateFileNameFromOriginal(string $originalFileName): string
    {
        $originalFileName = explode('.', $originalFileName);

        return self::generateFileName($originalFileName[1]);
    }
}