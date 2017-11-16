<?php


namespace UserBundle\Controller;


use AppBundle\Entity\Player;
use AppBundle\Form\PlayerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class SecurityController extends Controller
{
    /**
     *@return Response
     */
    public function loginAction()
    {
        $authentificationUt = $this->get('security.authentication_utils');
        $error = $authentificationUt->getLastAuthenticationError();
        $lastUsername = $authentificationUt->getLastUsername();
        return $this->render('UserBundle:security:login.html.twig', [
            'error'=>$error,
            'lastUsername'=>$lastUsername]);
    }
}