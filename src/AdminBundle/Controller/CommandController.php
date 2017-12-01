<?php

namespace AdminBundle\Controller;

use AppBundle\Entity\Card;
use AppBundle\Entity\Command;
use AppBundle\Form\CommandType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommandController extends Controller
{
    public function indexAction()
    {
        $commands = $this->getDoctrine()->getManager()->getRepository('AppBundle:Command')->findAllCommandsWithEtablishment();

        return $this->render('AdminBundle:command:index.html.twig', ['commands' => $commands]);

    }

    public function addAction(Request $request)
    {
        $command = new Command();
        $form = $this->createForm(CommandType::class, $command);

        if ($form->handleRequest($request) && $form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($command);
            $entityManager->flush();

            $this->addFlash('success', 'Félicitations, votre commande a bien été créée');

            return $this->redirectToRoute('admin_command_index');
        }

        return $this->render('@Admin/command/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function showAction($id)
    {
        $command = $this->getDoctrine()->getManager()->getRepository('AppBundle:Command')->findOneCommandWithEtablishment($id);

        dump($command);

        if (null == $command) {
            new notFoundHttpException('La commande demandée n\'existe pas');
        }

        return $this->render('@Admin/command/show.html.twig', ['command' => $command]);
    }

    public function deliveryAction($id)
    {
        $command = $this->getDoctrine()->getManager()->getRepository('AppBundle:Command')->find($id);
        $commandManager = $this->get('admin_command_manager');

        $commandManager->toOrderFromInStoreStatusCard($command->getId());


        return $this->redirectToRoute('admin_command_show', ['id'=>$command->getId()]);
    }
}
