<?php

namespace AppBundle\Service;

use AppBundle\Entity\Card;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Workflow\Workflow;

class CardManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var Workflow
     */
    private $workflow;

    public function __construct(EntityManagerInterface $entityManager, Workflow $workflow)
    {
        $this->entityManager = $entityManager;
        $this->workflow = $workflow;
    }

    /**
     * @param $id_player
     * @param $card_number
     * @throws \Exception
     */
    public function addCard($id_player, $card_number)
    {
        $player = $this->entityManager->getRepository('AppBundle:Player')->find($id_player);
        $card = $this->entityManager->getRepository('AppBundle:Card')->findOneBy(['number' => $card_number]);
        if(is_null($card) || !$this->workflow->can($card, 'activation')) {
            throw new \Exception('Erreur carte');
        }
        if(!empty($card->getPlayer())) {
            throw new \Exception('La carte a déjà été utilisée');
        }
        $this->workflow->apply($card, 'activation');
        $card->setPlayer($player);
        $this->entityManager->persist($card);
        $this->entityManager->flush();
    }

    public function disableCard(Card $card){
        if(!$this->workflow->can($card, 'deactivation')) {
            throw new \Exception('Erreur carte');
        }
        $this->workflow->apply($card, 'deactivation');
        $this->entityManager->persist($card);
        $this->entityManager->flush();
    }

    /**
     * CODE_CENTRE : 3 chiffres décrivant un établissement
     * CODE_CARTE : 6 chiffres décrivant un client
     * checksum : somme des chiffres précédents modulo 9
     */
    public static function generateNumber()
    {
        $code_centre = 123;
        //TODO faire les 0
        $code_carte = rand(100000, 999999);
        $somme_chiffre = $code_centre.$code_carte;
        $array = str_split($somme_chiffre);
        $checksum = array_sum($array) % 9;
        return $code_centre.$code_carte.$checksum;
    }
}