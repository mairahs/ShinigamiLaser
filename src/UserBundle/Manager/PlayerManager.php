<?php


namespace UserBundle\Manager;

use AppBundle\Entity\Player;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;


class PlayerManager
{
    private $entityManager;
    private $encoder;
    private $tokenStorage;
    private $router;

    public function __construct(ObjectManager $entityManager, EncoderFactoryInterface $encoder, TokenStorageInterface $tokenStorage, RouterInterface $router)
    {
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
        $this->tokenStorage = $tokenStorage;
        $this->router = $router;
    }

    protected function getRepository()
    {
        return $this->entityManager->getRepository(Player::class);
    }


    public function save(Player $player)
    {
        $hashedPassword = $this->encoder->getEncoder(Player::class)->encodePassword($player->getPassword(), $player);
        $player->setPassword($hashedPassword);
        $this->entityManager->persist($player);
        $this->entityManager->flush();
    }

    public function test(Player $player)
    {
        $player->setLastname('nomtest');
        $player->setFirstname('prenomtest');
        $player->setEmail('test@test.com');
        $player->setAddress('20 rue saint lazare');
        $player->setPhoneNumber('060000000');
        $player->setUsername('pseudo');
        $player->setDateOfBirth(new \DateTime());
        $player->setToken(45666);
        $player->setIsActivate(0);
        return $player;
    }
}