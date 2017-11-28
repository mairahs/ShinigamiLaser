<?php


namespace AdminBundle\Controller;

use AppBundle\Manager\CardManager;
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
            try{
                $player = $this->getDoctrine()->getRepository('AppBundle:Player')->findPlayerByNumberCard($numberCard);
                $ret = $this->get(CardManager::class)->returnDashboard($player);
                return $this->render('default/dashboard.html.twig', $ret);
            }catch(\Exception $exception){
                $this->addFlash('notice', "Aucun joueur ne possède ce numéro de carte");
            }
        }
        return $this->render('@Admin/user/find_player.html.twig');
    }

    public function showAction($id)
    {
        $player = $this->getDoctrine()->getManager()->getRepository('AppBundle:Player')->find($id);
        $ret = $this->get(CardManager::class)->returnDashboard($player);
        return $this->render('default/dashboard.html.twig', $ret);
    }


}
