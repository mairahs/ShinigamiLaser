<?php

namespace UserBundle\Controller;

use AppBundle\Entity\Player;
use AppBundle\Form\PlayerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\FormUpdate\UpdateAvatarType;
use UserBundle\FormUpdate\UpdatePasswordType;
use UserBundle\Manager\AuthenticateService;
use UserBundle\Manager\PlayerManager;

class UpdateController extends Controller
{
    /**
     * edit profile of a player
     * @param Request $request
     * @param Player  $player
     *
     * @return Response
     *
     * @internal param Request $request
     * @internal param Player $player
     * @internal param $id
     */
    public function profilAction(Request $request, Player $player)
    {
        $this->get(AuthenticateService::class)->checkPlayer($player);
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get(PlayerManager::class)->update($player);

            return $this->redirectToRoute('app_dashboard', ['id' => $player->getId()]);
        }

        return $this->render('UserBundle:update:update.profil.html.twig', ['form' => $form->createView(), 'player' => $player]);
    }

    /**
     * update avatar
     * @param Request $request
     * @param Player  $player
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function avatarAction(Request $request, Player $player)
    {
        $this->get(AuthenticateService::class)->checkPlayer($player);
        $form = $this->createForm(UpdateAvatarType::class, $player);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get(PlayerManager::class)->update($player);

            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('UserBundle:update:update.avatar.html.twig', ['form' => $form->createView(), 'player' => $player]);
    }

    /**
     * update password
     * @param Request $request
     * @param Player  $player
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function passwordAction(Request $request, Player $player)
    {
        $this->get(AuthenticateService::class)->checkPlayer($player);
        $form = $this->createForm(UpdatePasswordType::class, $player);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $oldPassword = $request->get('userbundle_password')['oldPassword'];
            $this->get(PlayerManager::class)->findPassword($player, $oldPassword);
            $this->get(PlayerManager::class)->save($player);

            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('UserBundle:update:update.password.html.twig', ['form' => $form->createView(), 'player' => $player]);
    }
}
