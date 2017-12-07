<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Game;
use Doctrine\ORM\Event\LifecycleEventArgs;

class PrePersistGame
{
    /**
     * Event for automatically change the booking  of game before persist.
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $object = $args->getObject();
        if (!$object instanceof Game) {
            return;
        }
        $object->setBooking(1);
    }
}
