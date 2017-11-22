<?php


namespace UserBundle\EventListener;

use AppBundle\Entity\Player;
use Doctrine\ORM\Event\LifecycleEventArgs;
use UserBundle\Manager\PlayerManager;

class PrePersistPlayerListener
{
    public function prePersist(LifecycleEventArgs $args)
    {
        $object = $args->getObject();
        if (!$object instanceof Player) {
            return;
        }
        $token = PlayerManager::generateToken($object);
        $object->setToken($token);
        $object->setIsActivate(0);
    }
}
