<?php


namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EtablishmentController extends Controller
{
    public function indexAction()
    {
        $etablishments = $this->getDoctrine()->getManager()->getRepository('AppBundle:Etablishment')->getAllEtablishmentsWithGames();

        return $this->render('@Admin/etablishment/index.html.twig', ['etablishments'=>$etablishments]);
    }


    public function showAction($id)
    {
        $etablishment = $this->getDoctrine()->getManager()->getRepository('AppBundle:Etablishment')->find($id);

        if(null == $etablishment)
        {
            throw new NotFoundHttpException('L\'établissement demandé n\'existe pas');
        }

        return $this->render('@Admin/etablishment/show.html.twig', ['etablishment'=>$etablishment]);
    }
}