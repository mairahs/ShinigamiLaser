<?php


namespace AdminBundle\Controller;

use AppBundle\Service\CardManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function findAction(Request $request)
    {
        $numberCard = $request->request->get('number_card');
        if ($request->getMethod() === "POST" && !is_null($numberCard) && $numberCard !== "") {
            $player = $this->getDoctrine()->getRepository('AppBundle:Player')->findPlayerByNumberCard($numberCard);


            if (null === $player) {
                throw new NotFoundHttpException("Aucun joueur ne possède ce numéro de carte");
            }

            return  $this->redirectToRoute('admin_displayplayer', ['id'=>$player->getId()]);
        }

        return $this->render('@Admin/user/find_player.html.twig');
    }

    public function displayAction($id)
    {
        $player = $this->getDoctrine()->getRepository('AppBundle:Player')->find($id);
        $cards = $this->getDoctrine()->getRepository('AppBundle:Score')->getListCardDashboard($player);
        $stats = $this->get(CardManager::class)->getStatsDashboard($cards);
        return $this->render('default/dashboard.html.twig', [
            'player' => $player,
            'cards' => $cards,
            'stats' => $stats
        ]);
    }
}
