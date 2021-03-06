<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Command.
 *
 * @ORM\Table(name="command")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommandRepository")
 */
class Command
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_order", type="datetime")
     */
    private $dateOfOrder;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Etablishment", inversedBy="commands")
     */
    private $etablishment;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Card", mappedBy="command", cascade={"persist"})
     */
    private $cards;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return \DateTime
     */
    public function getDateOfOrder()
    {
        return $this->dateOfOrder;
    }

    /**
     * @param \DateTime $dateOfOrder
     */
    public function setDateOfOrder($dateOfOrder)
    {
        $this->dateOfOrder = $dateOfOrder;
    }

    /**
     * Set etablishment.
     *
     * @param \AppBundle\Entity\Etablishment $etablishment
     *
     * @return Command
     */
    public function setEtablishment(\AppBundle\Entity\Etablishment $etablishment = null)
    {
        $this->etablishment = $etablishment;

        return $this;
    }

    /**
     * Get etablishment.
     *
     * @return \AppBundle\Entity\Etablishment
     */
    public function getEtablishment()
    {
        return $this->etablishment;
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->cards = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add card.
     *
     * @param \AppBundle\Entity\Card $card
     *
     * @return Command
     */
    public function addCard(\AppBundle\Entity\Card $card)
    {
        $this->cards[] = $card;

        return $this;
    }

    /**
     * Remove card.
     *
     * @param \AppBundle\Entity\Card $card
     */
    public function removeCard(\AppBundle\Entity\Card $card)
    {
        $this->cards->removeElement($card);
    }

    /**
     * Get cards.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCards()
    {
        return $this->cards;
    }
}
