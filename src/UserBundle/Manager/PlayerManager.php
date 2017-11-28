<?php

namespace UserBundle\Manager;

use AppBundle\Entity\Player;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class PlayerManager
{
    private $entityManager;
    private $encoder;
    private $tokenStorage;
    private $router;
    /**
     * @var MailManager
     */
    private $mailManager;

    public function __construct(ObjectManager $entityManager, EncoderFactoryInterface $encoder, TokenStorageInterface $tokenStorage, RouterInterface $router, MailManager $mailManager)
    {
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
        $this->tokenStorage = $tokenStorage;
        $this->router = $router;
        $this->mailManager = $mailManager;
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
        $this->mailManager->sendMailToPlayer($player);
    }

    public function resetPassword(Player $player)
    {
        $hashedPassword = $this->encoder->getEncoder(Player::class)->encodePassword($player->getPassword(), $player);
        $player->setPassword($hashedPassword);
        $this->entityManager->persist($player);
        $this->entityManager->flush();
    }

    public function update(Player $player)
    {
        $this->entityManager->persist($player);
        $this->entityManager->flush();
    }

    public function findPassword(Player $player, $oldPassword)
    {
        //TODO Activer la recherche
//        $hashedPassword = $this->encoder->getEncoder(Player::class)->isPasswordValid($oldPassword, $player);
//        $find = $this->entityManager->getRepository('AppBundle:Player')->findOneBy(['password' => $hashedPassword, 'id' => $player->getId()]);
//        if(is_null($find)){
//            throw new \Exception("Le mot de passe n'est pas correct");
//        }
    }

    public function activate($token)
    {
        $player = $this->entityManager->getRepository('AppBundle:Player')->findOneBy(['token' => $token]);
        $player->setIsActivate(1);
        $this->entityManager->persist($player);
        $this->entityManager->flush();
        return $player;
    }

    public function test(Player $player)
    {
        $player->setLastname('nomtest');
        $player->setFirstname('prenomtest');
        $player->setEmail('test@test.com');
        $player->setAddress('20 rue saint lazare');
        $player->setPhoneNumber('060000000');
        $player->setDateOfBirth(new \DateTime());

        return $player;
    }

    public static function generateToken(Player $player)
    {
        $username = $player->getUsername();
        $timestamp = 1234567890;
        $date_time = \date('dmY', $timestamp);
        $key = $username.$date_time;
        $hash = hash('sha256', $key);

        return $hash;
    }
}
