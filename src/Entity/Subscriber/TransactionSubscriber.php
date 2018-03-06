<?php

declare(strict_types = 1);

namespace App\Entity\Subscriber;

use App\Entity\Contracts\FileAwareInterface;
use App\Entity\Transaction;
use App\Service\Storage\File;
use App\Service\Storage\TransactionStorage;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class TransactionSubscriber
 */
class TransactionSubscriber implements EventSubscriber
{
    /** @var TransactionStorage */
    private $storage;

    /**
     * TimeblameableSubscriber constructor.
     *
     * @param TransactionStorage $storage
     */
    public function __construct(TransactionStorage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            'prePersist',
            'postPersist',
            'postRemove'
        ];
    }

    /**
     * @param LifecycleEventArgs $args
     *
     * @return bool
     */
    private function isSupported(LifecycleEventArgs $args): bool
    {
        if (
            !$args->getEntity() instanceof Transaction
            || !$args->getEntity() instanceof FileAwareInterface
        ) {
            return false;
        }

        return true;
    }



    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        if (!$this->isSupported($args)) {
            return;
        }

        /** @var Transaction $entity */
        $entity = $args->getEntity();
        $uploadedFile = $entity->getUploadedFile();

        if (!$uploadedFile instanceof UploadedFile || !$uploadedFile->isValid()) {
            return;
        }

        $tmpFileName = uniqid();

        $uploadedFile->move('/tmp', $tmpFileName);
        $newFileName = File::generateFileName($uploadedFile->guessClientExtension());

        $entity->setFileName($newFileName);
        $entity->setMimeType($uploadedFile->getClientMimeType());
        $entity->setFileContent(file_get_contents('/tmp/'.$tmpFileName));
        $entity->setUploadedFile(null);

        unset($uploadedFile);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        if (!$this->isSupported($args)) {
            return;
        }

        /** @var Transaction $entity */
        $entity = $args->getEntity();

        if (null === $entity->getFileName()) {
            return;
        }

        $this->storage->save($entity);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        if (!$this->isSupported($args)) {
            return;
        }

        /** @var Transaction $entity */
        $entity = $args->getEntity();

        if (null === $entity->getFileName()) {
            return;
        }

        $this->storage->delete($entity);
    }
}
