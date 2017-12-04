<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EtablishmentController extends Controller
{
    public function indexAction()
    {
        $etablishments = $this->getDoctrine()->getManager()->getRepository('AppBundle:Etablishment')->getAllEtablishmentsWithGames();

        return $this->render('@Admin/etablishment/index.html.twig', ['etablishments' => $etablishments]);
    }


    public function  indexBookingTrueAction()
    {
        $gamesBookingTrue = $this->getDoctrine()->getManager()->getRepository('AppBundle:Etablishment')->findAllEtablishmentsWithBookingTrue();

        dump($gamesBookingTrue);
        return $this->render('@Admin/etablishment/indexbookingtrue.html.twig', ['gamesBookingTrue'=>$gamesBookingTrue]);
    }

    public function  indexBookingFalseAction()
    {
        $gamesBookingFalse = $this->getDoctrine()->getManager()->getRepository('AppBundle:Etablishment')->findAllEtablishmentsWithBookingFalse();

        return $this->render('@Admin/etablishment/indexbookingfalse.html.twig', ['gamesBookingFalse'=>$gamesBookingFalse]);
    }

    public function usersAction()
    {
        $etablishments = $this->getDoctrine()->getManager()->getRepository('AppBundle:Etablishment')->getPlayersByEtablishment();

        return $this->render('@Admin/etablishment/users.html.twig', ['etablishments' => $etablishments]);
    }

    public function showAction($id)
    {
        $etablishment = $this->getDoctrine()->getManager()->getRepository('AppBundle:Etablishment')->find($id);

        if (is_null($etablishment)) {
            throw new NotFoundHttpException('L\'établissement demandé n\'existe pas');
        }
        $stats['count_abonne'] = $this->getDoctrine()->getRepository('AppBundle:Card')->getCountAbonne($etablishment);
        return $this->render('@Admin/etablishment/show.html.twig', [
            'etablishment' => $etablishment,
            'stats' => $stats,
        ]);
    }
}
