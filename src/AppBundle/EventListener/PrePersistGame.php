<?php
/**
 * Created by PhpStorm.
 * User: Tonio
 * Date: 28/11/2017
 * Time: 13:37
 */

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