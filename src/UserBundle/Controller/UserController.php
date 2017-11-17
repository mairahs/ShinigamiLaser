<?php


namespace UserBundle\Controller;


use AppBundle\Entity\Player;
use AppBundle\Form\PlayerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Manager\MailManager;
use UserBundle\Manager\PlayerManager;

class UserController extends Controller
{
    public function registerAction(Request $request)
    {
        $player = new Player();
        if($this->get('kernel')->getEnvironment() === "dev" && $request->get('t') === "1"){
            $player = $this->get(PlayerManager::class)->test($player);
        }
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get(PlayerManager::class)->save($player);
            return $this->redirectToRoute('user_preactivate');

        }

        return $this->render('UserBundle:default:register.html.twig', ['form'=> $form->createView()]);
    }

    /**
     * @param Request $request
     * @param Player $player
     * @return Response
     * @internal param Request $request
     * @internal param Card $card
     * @internal param $id
     */
    public function updateAction(Request $request, Player $player){
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get(PlayerManager::class)->save($player);

            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('UserBundle:default:edit.html.twig', ['form' => $form->createView(), 'player' => $player]);
    }

    public function activateAccountAction($token)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $player = $entityManager->getRepository('AppBundle:Player')->findOneBy(['token' => $token]);
        $player->setIsActivate(1);
        $entityManager->persist($player);
        $entityManager->flush();

        return $this->render('UserBundle:default:activate.html.twig', ['player'=> $player]);
    }

    public function lost_passwordAction(Request $request)
    {
        $email = $request->request->get('_email');
        if ($request->getMethod() === "POST" && !is_null($email) && $email !== "") {
            $player = $this->getDoctrine()->getRepository('AppBundle:Player')->findOneBy(['email' => $email]);
            if(!$player)
            {
                throw new AccessDeniedException('Email non trouvé');
            }
            $token = PlayerManager::generateToken($player);
            $mailer = $this->get(MailManager::class);
            $mailer->sendMailLostPassword($player);
            return $this->render('UserBundle:email:mail.lost_password.html.twig', ['player'=>$player, 'token'=>$token]);
        }
        return $this->render('UserBundle:default:prelostpassword.html.twig');
    }

    public function updatePasswordAction()
    {
        return new Response('Coucou');
    }


}