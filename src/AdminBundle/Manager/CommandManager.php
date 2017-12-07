<?php

namespace AdminBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Workflow\Registry;

class CommandManager
{
    private $entityManager;
    private $stateMachine;

    public function __construct(EntityManager $entityManager, Registry $stateMachine)
    {
        $this->entityManager = $entityManager;
        $this->stateMachine = $stateMachine;
    }

    /**
     * Apply a transition delivery on ordered cards for one command.
     *
     * @param $id
     */
    public function toOrderFromInStoreStatusCard($id)
    {
        $command = $this->entityManager->getRepository('AppBundle:Command')->findOneCommandWithCards($id);
        $cards = $command->getCards();

        foreach ($cards as $card) {
            $workflow = $this->stateMachine->get($card);
            if ($workflow->can($card, 'delivery')) {
                $workflow->apply($card, 'delivery');

                $this->entityManager->persist($card);
                $this->entityManager->flush();
            } else {
                new notFoundHttpException('La transition ne peut pas etre effectuée');
            }
        }
    }
}
