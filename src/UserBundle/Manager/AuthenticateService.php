<?php
/**
 * Created by PhpStorm.
 * User: Tonio
 * Date: 17/11/2017
 * Time: 09:54.
 */

namespace UserBundle\Manager;

use AppBundle\Entity\Player;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class AuthenticateService
{
    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    public function __construct(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * check if the player connected is not a real player =>access denied
     * @param Player $player
     */
    public function checkPlayer(Player $player)
    {
        if ($this->tokenStorage->getToken()->getUser()->getId() !== $player->getId()) {
            throw new AccessDeniedException('Accès non autorisé');
        }
    }

    /**
     * check if the player connected is a real player
     * @param Player $player
     * @return bool
     */
    public function isPlayer(Player $player)
    {
        return $this->tokenStorage->getToken()->getUser()->getId() === $player->getId();
    }
}
