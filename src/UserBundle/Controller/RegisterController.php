<?php
/**
 * Created by PhpStorm.
 * User: Tonio
 * Date: 21/11/2017
 * Time: 15:21.
 */

namespace UserBundle\Controller;

use AppBundle\Entity\Player;
use AppBundle\Form\PlayerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Manager\PlayerManager;

class RegisterController extends Controller
{
    public function formAction(Request $request)
    {
        $player = new Player();
        if ('dev' === $this->get('kernel')->getEnvironment() && '1' === $request->get('t')) {
            $player = $this->get(PlayerManager::class)->test($player);
        }
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get(PlayerManager::class)->save($player);

            return $this->redirectToRoute('user_register_confirmation');
        }

        return $this->render('UserBundle:register:register.form.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param $token
     *
     * @return Response
     */
    public function activateAction($token)
    {
        $this->get(PlayerManager::class)->activate($token);

        return $this->render('UserBundle:register:register.activate.html.twig', ['player' => $player]);
    }
}
