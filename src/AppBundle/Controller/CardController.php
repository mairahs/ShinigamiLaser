<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Card;
use AppBundle\Form\CardType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class CardController
 * @package AppBundle\Controller
 * @Route("/card")
 */
class CardController extends Controller
{
    /**
     * @Route("/add", name="app_card_add")
     */
    public function addAction(){
        $card = new Card();

        $form = $this->createForm($card, CardType::class);

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