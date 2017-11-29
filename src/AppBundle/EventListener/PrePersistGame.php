<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Game;
use Doctrine\ORM\Event\LifecycleEventArgs;

class PrePersistGame
{
    public function prePersist(LifecycleEventArgs $args)
    {
        $object = $args->getObject();
        if (!$object instanceof Game) {
            return;
        }
        $object->setBooking(1);
    }
}
