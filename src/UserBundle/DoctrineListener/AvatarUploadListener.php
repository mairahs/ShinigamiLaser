<?php


namespace UserBundle\DoctrineListener;

use AppBundle\Entity\Avatar;
use Doctrine\ORM\Event\LifecycleEventArgs;


class AvatarUploadListener
{
    private $projectDir;

    public function __construct($projectDir)
    {
        $this->projectDir = $projectDir;
    }

    public function postPersist(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();
        if ($entity instanceof Avatar) {
            $file = $entity->getFile();

            $fileName = $entity->getName().'.'.$entity->getExtension();

            $file->move(
                $this->projectDir.'/web/upload',
                $fileName
            );

        }

    }
}

