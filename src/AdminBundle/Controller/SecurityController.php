<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller
{
    public function dashboardAction()
    {
        return $this->render('AdminBundle:security:dashboard.html.twig');
    }

    /**
     * login admin
     *@return Response
     */
    public function login_adminAction()
    {
        $authentificationUt = $this->get('security.authentication_utils');
        $error = $authentificationUt->getLastAuthenticationError();
        $lastUsername = $authentificationUt->getLastUsername();

        return $this->render('@User/security/login.html.twig', [
            'error' => $error,
            'lastUsername' => $lastUsername,
            'admin' => true,
        ]);
    }
}
