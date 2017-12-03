<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Game;
use AppBundle\Form\GameType;
use AppBundle\Manager\GameManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GameController extends Controller
{
    public function addAction(Request $request)
    {
        $game = new Game();
        $form = $this->createForm(GameType::class, $game);

        if ($form->handleRequest($request) && $form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($game);
            $entityManager->flush();

            $this->addFlash('success', 'Félicitations, votre partie a bien été créée');

            return $this->redirectToRoute('app_game_show', array('id' => $game->getId()));
        }

        return $this->render('game/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function  indexBookingTrueAction()
    {
        $gamesBookingTrue = $this->getDoctrine()->getManager()->getRepository('AppBundle:Game')->findAllGamesWithBookingTrue();

        return $this->render('game/indexbookingtrue.html.twig', ['gamesBookingTrue'=>$gamesBookingTrue]);
    }

    public function  indexBookingFalseAction()
    {
        $gamesBookingFalse = $this->getDoctrine()->getManager()->getRepository('AppBundle:Game')->findAllGamesWithBookingFalse();

        return $this->render('game/indexbookingfalse.html.twig', ['gamesBookingFalse'=>$gamesBookingFalse]);
    }

    public function showAction($id)
    {
        $game = $this->getDoctrine()->getManager()->getRepository('AppBundle:Game')->getOneGameWithScoreAndPlayer($id);
        if (null == $game) {
            new notFoundHttpException('La partie demandée n\'existe pas');
        }
        $hasCard = $this->get(GameManager::class)->hasCard($game);
        if($hasCard){
            $cards = $this->get(GameManager::class)->getCard($game);
        }else{
            $cards = $this->get(GameManager::class)->getCard();
        }

        return $this->render('game/show.html.twig', [
            'game' => $game,
            'cards' => $cards,
            'hasCard' => $hasCard
        ]);
    }

    public function joinAction($from, $id_game, $id_card)
    {
        $this->get(GameManager::class)->joinGame($id_game, $id_card);

        if($from == "dash"){
            return $this->redirectToRoute('app_dashboard');
        }else{
            return $this->redirectToRoute('app_game_show', ['id' => $id_game]);
        }
    }

    public function unjoinAction($from, $id_game, $id_card)
    {
        $this->get(GameManager::class)->unjoinGame($id_game, $id_card);

        if($from == "dash"){
            return $this->redirectToRoute('app_dashboard');
        }else{
            return $this->redirectToRoute('app_game_show', ['id' => $id_game]);
        }
    }

    /**
     * @param $id_game
     * @param $card_number
     * @return JsonResponse
     */
    public function addPlayerAction($id_game, $card_number){
        try {
            $id_card = $this->get(GameManager::class)->findPlayerCard($id_game, $card_number);
            $ret['status'] = 'OK';
            $response = $this->redirectToRoute('app_game_join', ['from' => 'game', 'id_card' => $id_card,'id_game' => $id_game]);
            $ret['retour'] = $response->getTargetUrl();
        } catch (\Exception $exception) {
            $ret['status'] = 'KO';
            $ret['retour'] = $exception->getMessage();
        }
        return new JsonResponse($ret);
    }
}
