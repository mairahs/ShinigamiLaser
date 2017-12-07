<?php

namespace AdminBundle\EventListener;

use AppBundle\Entity\Card;
use AppBundle\Entity\Command;
use Doctrine\ORM\Event\LifecycleEventArgs;

class PrePersistCommand
{
    /**
     * event new command=>new card(number of card = quantity of command)
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $object = $args->getObject();
        if (!$object instanceof Command) {
            return;
        }

        $quantity = $object->getQuantity();

        for ($i = 1; $i <= $quantity; ++$i) {
            $card = new Card();
            $card->setCommand($object);
            $object->addCard($card);
        }

        $object->setDateOfOrder(new \DateTime());
    }
}
