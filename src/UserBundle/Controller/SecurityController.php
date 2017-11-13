<?php


namespace UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller
{
    /**
     *@return Response
     */
    public function loginAction()
    {
        return $this->render('UserBundle:security:login.html.twig');
    }
}