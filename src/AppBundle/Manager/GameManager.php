<?php
/**
 * Created by PhpStorm.
 * User: Tonio
 * Date: 28/11/2017
 * Time: 16:29.
 */

namespace AppBundle\Manager;

use AppBundle\Entity\Game;
use AppBundle\Entity\Player;
use AppBundle\Entity\Score;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Workflow\Workflow;

class GameManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var TokenStorage
     */
    private $tokenStorage;
    /**
     * @var Workflow
     */
    private $workflow;

    public function __construct(EntityManagerInterface $entityManager, TokenStorage $tokenStorage, Workflow $workflow)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->workflow = $workflow;
    }

    public function joinGame($id_game, $id_card)
    {
        $score = new Score();
        $game = $this->entityManager->getRepository('AppBundle:Game')->find($id_game);
        $card = $this->entityManager->getRepository('AppBundle:Card')->find($id_card);
        $team = $this->manageTeam($game);
        $score->setResult(0)
            ->setGames($game)
            ->setCards($card)
            ->setTeam($team);
        $this->entityManager->persist($score);
        $this->entityManager->flush();
    }

    public function unjoinGame($id_game, $id_card)
    {
        $score = $this->entityManager->getRepository('AppBundle:Score')->findOneBy([
            'games' => $id_game,
            'cards' => $id_card,
        ]);
        $this->entityManager->remove($score);
        $this->entityManager->flush();
    }

    public function getCard(Game $game = null)
    {
        $player = $this->tokenStorage->getToken()->getUser();
        $cards = null;
        if($player instanceof Player){
            if(!is_null($game)){
                $cards = $this->entityManager->getRepository('AppBundle:Card')->getListCardByGame($player, $game);
            }else{
                $cards = $this->entityManager->getRepository('AppBundle:Card')->getListCard($player);
            }
        }
        return $cards;
    }

    public function hasCard(Game $game){
        $player = $this->tokenStorage->getToken()->getUser();
        $cards = "0";
        if($player instanceof Player){
            $cards = $this->entityManager->getRepository('AppBundle:Card')->hasCard($player, $game);
        }
        return "0" !== $cards;
    }

    /**
     * @param $card_number
     * @throws \Exception
     */
    public function findPlayerCard($id_game, $card_number){
        $card = $this->entityManager->getRepository('AppBundle:Card')->findCardAndPlayerByNumber($card_number);
        if (empty($card)) {
            throw new \Exception('Carte introuvable');
        }
        if(!$this->workflow->can($card[0], 'deactivation')) {
            throw new \Exception("La carte n'est pas valide");
        }
        $game = $this->entityManager->getRepository('AppBundle:Game')->find($id_game);
        $hasCard = $this->entityManager->getRepository('AppBundle:Card')->hasCard($card[0]->getPlayer(), $game);
        if ($hasCard) {
            throw new \Exception('Le joueur est déjà dans la partie');
        }
        return $card[0]->getId();
    }

    /**
     * @param Game $game
     * @return int
     */
    public function manageTeam(Game $game)
    {
        if(!$game->getGameType()->getTeam()){
            return 0;
        }
        $team1 = $this->entityManager->getRepository('AppBundle:Score')->findBy(['team' => 1, 'games' => $game]);
        $team2 = $this->entityManager->getRepository('AppBundle:Score')->findBy(['team' => 2, 'games' => $game]);
        if($team1 <= $team2){
            $team = 1;
        }else{
            $team = 2;
        }
        return $team;
    }
}
