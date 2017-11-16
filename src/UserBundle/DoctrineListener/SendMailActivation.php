<?php


namespace UserBundle\DoctrineListener;

use AppBundle\Entity\Player;
use Doctrine\ORM\Event\LifecycleEventArgs;
use UserBundle\Manager\MailManager;

class SendMailActivation
{
    /**
     * @var mailManager
     */
    private $mailManager;

    public function __construct(MailManager $mailManager)
    {
        $this->mailManager = $mailManager;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $object = $args->getObject();
        if (!$object instanceof Player) {
            return;
        }
        $this->mailManager->sendMailToPlayer($object);
    }
}