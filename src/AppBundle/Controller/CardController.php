<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Card;
use AppBundle\Form\CardType;
use AppBundle\Manager\CardManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Manager\AuthenticateService;

/**
 * Class CardController.
 *
 * @Route("/card")
 */
class CardController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $card = new Card();
        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            try {
                $this->get(CardManager::class)->addCard($user->getId(), $request->get('appbundle_card')['number']);

                return $this->redirectToRoute('app_dashboard');
            } catch (\Exception $exception) {
                $this->addFlash('notice', $exception->getMessage());
            }
        }

        return $this->render('card/add.card.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param Card $card
     *
     * @return Response
     *
     * @internal param Request $request
     * @internal param $id
     */
    public function showAction(Card $card)
    {
        $stats = $this->getDoctrine()->getRepository('AppBundle:Score')->getAllStat($card);
        $stats['scores'] = $this->getDoctrine()->getRepository('AppBundle:Score')->getLastGamePlayedCard($card);
        $other = true;
        if ($this->get(AuthenticateService::class)->isPlayer($card->getPlayer())) {
            $other = false;
        }

        return $this->render('card/show.card.html.twig', [
            'card' => $card,
            'stats' => $stats,
            'other' => $other,
        ]);
    }

    public function disablePageAction($id)
    {
        $card = $this->getDoctrine()->getRepository('AppBundle:Card')->findOneBy(['id' => $id]);
        $this->get(AuthenticateService::class)->checkPlayer($card->getPlayer());
        $disableForm = $this->createDisableForm($card);

        return $this->render('card/disable.card.html.twig', array(
            'disable_form' => $disableForm->createView(),
        ));
    }

    /**
     * @param Request $request
     * @param Card    $card
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @internal param $id
     */
    public function disableAction(Request $request, Card $card)
    {
        $this->get(AuthenticateService::class)->checkPlayer($card->getPlayer());
        $form = $this->createDisableForm($card);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->get(CardManager::class)->disableCard($card);

                return $this->redirectToRoute('app_dashboard');
            } catch (\Exception $exception) {
                $this->addFlash('notice', $exception->getMessage());
            }
        }

        return $this->redirectToRoute('app_card_disable_page', ['id' => $card->getId()]);
    }

    /**
     * @param Card $card
     *
     * @internal param $id
     *
     * @return JsonResponse
     */
    public function scoreByGameAction(Card $card)
    {
        $game_type = $this->getDoctrine()->getRepository('AppBundle:GameType')->findAll();
        $stats = [];
        foreach ($game_type as $type) {
            $stats[$type->getType()] = $this->getDoctrine()->getRepository('AppBundle:Score')->getScoreByGame($card, $type);
        }

        return new JsonResponse($stats);
    }

    public function typepartieAction(Card $card)
    {
        $game_type = $this->getDoctrine()->getRepository('AppBundle:GameType')->findAll();
        $stats = [];
        foreach ($game_type as $type) {
            $stats[$type->getType()] = $this->getDoctrine()->getRepository('AppBundle:Score')->getTypePartie($card, $type);
        }

        return new JsonResponse($stats);
    }

    /**
     * @param Card $card
     *
     * @internal param $id
     *
     * @return JsonResponse
     */
    public function winloseAction(Card $card)
    {
        $stats = $this->getDoctrine()->getRepository('AppBundle:Score')->getWinlose($card);

        return new JsonResponse($stats);
    }

    /**
     * Creates a form to disable a card entity.
     *
     * @param Card $card
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createDisableForm(Card $card)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('app_card_disable_action', array('id' => $card->getId())))
            ->getForm()
            ;
    }
}
