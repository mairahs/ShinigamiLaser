<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\FormUpdate\UpdatePasswordType;
use UserBundle\Manager\MailManager;
use UserBundle\Manager\PlayerManager;

class LostPasswordController extends Controller
{
    /**
     * send mail when a player lost his password.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $email = $request->request->get('_email');
        if ('POST' === $request->getMethod() && !is_null($email) && '' !== $email) {
            $player = $this->getDoctrine()->getRepository('AppBundle:Player')->findOneBy(['email' => $email]);
            if (!is_null($player)) {
                $this->get(MailManager::class)->sendMailLostPassword($player);

                return $this->redirectToRoute('user_lostpassword_mailsend');
            }
            $this->addFlash('notice', "L'adresse email n'est pas valide");
        }

        return $this->render('UserBundle:lostpassword:lostpassword.index.html.twig');
    }

    /**
     * when a player want update his password.
     *
     * @param Request $request
     * @param $token
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
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
