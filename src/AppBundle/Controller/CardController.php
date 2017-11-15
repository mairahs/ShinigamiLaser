<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Card;
use AppBundle\Form\CardType;
use AppBundle\Service\CardManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CardController
 * @package AppBundle\Controller
 * @Route("/card")
 */
class CardController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request){
        $card = new Card();
        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user = $this->get('security.token_storage')->getToken()->getUser();
            try {
                $this->get(CardManager::class)->addCard($user->getId(), $request->get('appbundle_card')['number']);
                return $this->redirectToRoute('app_dashboard');
            }catch (\Exception $exception) {
                $this->addFlash('notice',$exception->getMessage());
            }
        }

        return $this->render('card/add.card.html.twig', ['form' => $form->createView()]);
    }

    public function disablePageAction($id)
    {
        //TODO Check si la carte n'appartient pas au bonhomme
        $card = $this->getDoctrine()->getRepository('AppBundle:Card')->find($id);
        $disableForm = $this->createDisableForm($card);
        return $this->render('card/disable.card.html.twig', array(
            'disable_form' => $disableForm->createView(),
        ));
    }

    /**
     * @param Request $request
     * @param Card $card
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param $id
     */
    public function disableAction(Request $request, Card $card)
    {
        $form = $this->createDisableForm($card);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->get(CardManager::class)->disableCard($card);

                return $this->redirectToRoute('app_dashboard');
            }catch (\Exception $exception) {
                $this->addFlash('notice',$exception->getMessage());
            }
        }

        return $this->redirectToRoute('app_card_disable_page', ['id' => $card->getId()]);
    }

    /**
     * Creates a form to disable a card entity.
     *
     * @param Card $card
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createDisableForm(Card $card)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('app_card_disable_action', array('id' => $card->getId())))
            ->getForm()
            ;
    }
}