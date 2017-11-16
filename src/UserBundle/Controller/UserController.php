<?php
/**
 * Created by PhpStorm.
 * User: Tonio
 * Date: 16/11/2017
 * Time: 09:51
 */

namespace UserBundle\Controller;


use AppBundle\Entity\Player;
use AppBundle\Form\PlayerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Manager\PlayerManager;

class UserController extends Controller
{
    public function registerAction(Request $request)
    {
        $player = new Player();
        if($this->get('kernel')->getEnvironment() === "dev" && $request->get('test') === "1"){
            $player = $this->get(PlayerManager::class)->test($player);
        }
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get(PlayerManager::class)->save($player);
            return $this->redirectToRoute('app_dashboard');
            //TODO: ENVOI DE MAIL POUR ACTIVATION DU COMPTE
        }

        return $this->render('UserBundle:security:register.html.twig', ['form'=> $form->createView()]);
    }
}