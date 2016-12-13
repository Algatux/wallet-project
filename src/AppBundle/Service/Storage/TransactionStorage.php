<?php

declare(strict_types=1);

namespace AppBundle\Service\Storage;

use AppBundle\Entity\Contracts\FileAwareInterface;
use AppBundle\Entity\Transaction;
use League\Flysystem\Filesystem;

/**
 * Class TransactionStorage
 */
class TransactionStorage
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * TransactionStorage constructor.
     *
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @param Transaction|FileAwareInterface $entity
     *
     * @return bool
     */
    public function save(FileAwareInterface $entity): bool
    {
        return $this->filesystem->write($entity->getFilename(), $entity->getFileContent());
    }

    /**
     * @param Transaction|FileAwareInterface $entity
     *
     * @return bool
     */
    public function delete(FileAwareInterface $entity): bool
    {
        return $this->filesystem->delete($entity->getFilename());
    }
}
