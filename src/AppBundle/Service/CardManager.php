<?php

namespace AppBundle\Service;

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
        if($this->workflow->can($card, 'activation')){
            $this->workflow->apply($card, 'activation');
            $card->setPlayer($player);
            $this->entityManager->persist($card);
            $this->entityManager->flush();
        }else{
            throw new \Exception('La transition "activation" ne peut pas être effectuée');
        }
    }
}