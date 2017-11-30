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
