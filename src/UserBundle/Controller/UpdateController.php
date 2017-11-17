<?php
/**
 * Created by PhpStorm.
 * User: Tonio
 * Date: 17/11/2017
 * Time: 08:14
 */

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
     * @param Player $player
     * @return Response
     */
    public function indexAction(Player $player){
        $this->get(AuthenticateService::class)->checkPlayer($player);
        return $this->render('@User/update/update.index.html.twig', [
            'player' => $player
        ]);
    }

    /**
     * @param Request $request
     * @param Player $player
     * @return Response
     * @internal param Request $request
     * @internal param Player $player
     * @internal param $id
     */
    public function profilAction(Request $request, Player $player){
        $this->get(AuthenticateService::class)->checkPlayer($player);
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get(PlayerManager::class)->update($player);

            return $this->redirectToRoute('user_update', ['id' => $player->getId()]);
        }

        return $this->render('UserBundle:update:update.profil.html.twig', ['form' => $form->createView(), 'player' => $player]);
    }

    public function avatarAction(Request $request, Player $player){
        $this->get(AuthenticateService::class)->checkPlayer($player);
        $form = $this->createForm(UpdateAvatarType::class, $player);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get(PlayerManager::class)->update($player);

            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('UserBundle:update:update.avatar.html.twig', ['form' => $form->createView(), 'player' => $player]);
    }

    public function passwordAction(Request $request, Player $player){
        $this->get(AuthenticateService::class)->checkPlayer($player);
        $form = $this->createForm(UpdatePasswordType::class, $player);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get(PlayerManager::class)->save($player);

            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('UserBundle:update:update.password.html.twig', ['form' => $form->createView(), 'player' => $player]);
    }
}