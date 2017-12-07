<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Card;
use AppBundle\Manager\CardManager;
use Doctrine\ORM\Event\LifecycleEventArgs;

class PrePersistCard
{
    /**
     * Event for automatically change the number and the status of card before persist.
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $object = $args->getObject();
        if (!$object instanceof Card) {
            return;
        }
        $center_number = $object->getCommand()->getEtablishment()->getCode();
        $number = CardManager::generateNumber($center_number);
        $object->setNumber($number);
        $object->setStatus('order');
    }
}
