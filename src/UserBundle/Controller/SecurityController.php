<?php


namespace UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller
{

    public function indexAction()
    {
        return new Response('<body><h2>Hello player</h2></body>');
    }
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