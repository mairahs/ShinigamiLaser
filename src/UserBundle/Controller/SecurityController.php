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
            'error' => $error,
            'lastUsername' => $lastUsername
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function registerAction(Request $request)
    {
        $player = new Player();

        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $playerManager = $this->get('player_manager');

            $playerManager->save($player);

            return $this->redirectToRoute('app_dashboard');

         //TODO: ENVOI DE MAIL POUR ACTIVATION DU COMPTE

        }

        return $this->render('UserBundle:security:register.html.twig', ['form'=> $form->createView()]);
    }


}