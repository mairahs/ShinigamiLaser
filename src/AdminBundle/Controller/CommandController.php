<?php

namespace AdminBundle\Controller;

use AppBundle\Entity\Command;
use AppBundle\Form\CommandType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommandController extends Controller
{
    /**
     * List of command
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $commands = $this->getDoctrine()->getManager()->getRepository('AppBundle:Command')->findAllCommandsWithEtablishment();

        return $this->render('AdminBundle:command:index.html.twig', ['commands' => $commands]);
    }

    /**
     * Form for add a new command
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
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

    /**
     * View one command
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id)
    {
        $command = $this->getDoctrine()->getManager()->getRepository('AppBundle:Command')->findOneCommandWithEtablishment($id);

        if (null == $command) {
            new notFoundHttpException('La commande demandée n\'existe pas');
        }

        return $this->render('@Admin/command/show.html.twig', ['command' => $command]);
    }

    /**
     * Changing command status workflow from in_store to order
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deliveryAction($id)
    {
        $command = $this->getDoctrine()->getManager()->getRepository('AppBundle:Command')->find($id);
        $commandManager = $this->get('admin_command_manager');

        $commandManager->toOrderFromInStoreStatusCard($command->getId());

        return $this->redirectToRoute('admin_command_show', ['id' => $command->getId()]);
    }
}
