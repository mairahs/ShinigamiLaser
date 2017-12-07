<?php

namespace UserBundle\EventSubscriber;

use AppBundle\Entity\Avatar;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

class AvatarUploadSubscriber implements EventSubscriber
{
    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            'postPersist',
            'postUpdate',
            'preUpdate',
        );
    }

    private $projectDir;

    public function __construct($projectDir)
    {
        $this->projectDir = $projectDir;
    }

    /**
     * Event automatically move avatar after persist
     * @param LifecycleEventArgs $event
     */
    public function postPersist(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();
        if ($entity instanceof Avatar) {
            $file = $entity->getFile();
            if (!is_null($file)) {
                $fileName = $entity->getName().'.'.$entity->getExtension();
                $file->move(
                    $this->projectDir.'/web/upload',
                    $fileName
                );
            }
        }
    }

    /**
     * @param LifecycleEventArgs $event
     */
    public function postUpdate(LifecycleEventArgs $event)
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

    /**
     * Event automatically delete the old avatar when update
     * @param LifecycleEventArgs $event
     */
    public function preUpdate(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();
        if ($entity instanceof Avatar) {
            if (!is_null($entity->getOldFileName()) && file_exists($this->projectDir.'/web/upload/'.$entity->getOldFileName())) {
                unlink($this->projectDir.'/web/upload/'.$entity->getOldFileName());
            }
        }
    }
}
