<?php
/**
 * Created by PhpStorm.
 * User: Tonio
 * Date: 17/11/2017
 * Time: 09:54.
 */

namespace UserBundle\Manager;

use AppBundle\Entity\Admin;
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
     * check if the player connected is not a real player =>access denied.
     *
     * @param Player $player
     */
    public function checkPlayer(Player $player)
    {
        if ($this->tokenStorage->getToken()->getUser()->getId() !== $player->getId()) {
            throw new AccessDeniedException('Accès non autorisé');
        }
    }

    /**
     * check if the player connected is a real player.
     *
     * @param Player $player
     *
     * @return bool
     */
    public function isPlayer(Player $player)
    {
        return $this->tokenStorage->getToken()->getUser()->getId() === $player->getId();
    }

    public function redirectFunct($route)
    {
        $redirect = null;
        if (is_null($this->tokenStorage->getToken())) {
            return $redirect;
        }
        $user = $this->tokenStorage->getToken()->getUser();
        switch ($route) {
            case 'user_login':
            case 'admin_login':
            case 'user_register':
            case 'user_register_confirmation':
            case 'user_register_activate':
                if ($user instanceof Player) {
                    $redirect = 'app_dashboard';
                }
                if ($user instanceof Admin) {
                    $redirect = 'admin_dashboard';
                }
            break;
        }

        return $redirect;
    }
}
