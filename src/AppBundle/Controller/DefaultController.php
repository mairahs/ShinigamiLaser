<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function dashboardAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        return $this->render('default/dashboard.html.twig', ['user' => $user]);
    }
}
