<?php
/**
 * Created by PhpStorm.
 * User: Tonio
 * Date: 17/11/2017
 * Time: 09:54
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

    public function checkPlayer(Player $player){
        if($this->tokenStorage->getToken()->getUser()->getId() !== $player->getId()){
            throw new AccessDeniedException('Accès non authorisé');
        }
    }
}