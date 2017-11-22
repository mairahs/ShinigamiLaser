<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use UserBundle\FormUpdate\UpdatePasswordType;
use UserBundle\Manager\MailManager;
use UserBundle\Manager\PlayerManager;

class LostPasswordController extends Controller
{
    public function indexAction(Request $request)
    {
        $email = $request->request->get('_email');
        if ($request->getMethod() === "POST" && !is_null($email) && $email !== "") {
            $player = $this->getDoctrine()->getRepository('AppBundle:Player')->findOneBy(['email' => $email]);
            if (!$player) {
                //todo afficher l'erreur dans la vue
                throw new AccessDeniedException('Email non trouvé');
            }
            $this->get(MailManager::class)->sendMailLostPassword($player);
            return $this->redirectToRoute('user_lostpassword_mailsend');
        }

        return $this->render('UserBundle:lostpassword:lostpassword.index.html.twig');
    }

    public function updateAction(Request $request, $token)
    {
        $player = $this->getDoctrine()->getRepository('AppBundle:Player')->findOneBy(['token' => $token]);
        $form = $this->createForm(UpdatePasswordType::class, $player);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get(PlayerManager::class)->resetPassword($player);
            return $this->redirectToRoute('user_lostpassword_confirmation');
        }

        return $this->render('UserBundle:update:update.password.html.twig', ['form' => $form->createView(), 'player' => $player]);
    }
}
