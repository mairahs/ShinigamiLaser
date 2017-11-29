<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Card;
use AppBundle\Manager\CardManager;
use Doctrine\ORM\Event\LifecycleEventArgs;

class NumberGenerator
{
    public function prePersist(LifecycleEventArgs $args)
    {
        $object = $args->getObject();
        if (!$object instanceof Card) {
            return;
        }
        $center_number = $object->getEtablishment()->getCode();
        $number = CardManager::generateNumber($center_number);
        $object->setNumber($number);
    }
}
