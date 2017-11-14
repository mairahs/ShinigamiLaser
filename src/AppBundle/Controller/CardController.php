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
     * @Route("/add", name="app_card_add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request){
        $card = new Card();
        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->get(CardManager::class)->addCard(8, $request->get('appbundle_card')['number']);
            return $this->redirectToRoute('app_dashboard');
        }
        return $this->render('card/add.card.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/remove/{id}", name="app_card_remove")
     */
    public function removeAction(){

    }

    /**
     * @Route("/disable/{id}", name="app_card_disable")
     */
    public function disableAction(){

    }
}