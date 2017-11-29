<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Card.
 *
 * @ORM\Table(name="card")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CardRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Card
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
     * @var string
     *
     * @ORM\Column(name="number", type="string", unique=true)
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Player", inversedBy="cards")
     */
    private $player;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Score", mappedBy="cards")
     */
    private $score;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Etablishment", inversedBy="cards")
     */
    private $etablishment;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Command")
     * @ORM\JoinColumn(nullable=false)
     */
    private $command;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set status.
     *
     * @param string $status
     *
     * @return Card
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set player.
     *
     * @param \AppBundle\Entity\Player $player
     *
     * @return Card
     */
    public function setPlayer(\AppBundle\Entity\Player $player = null)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player.
     *
     * @return \AppBundle\Entity\Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Set number.
     *
     * @param string $number
     *
     * @return Card
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number.
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->score = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add score.
     *
     * @param \AppBundle\Entity\Score $score
     *
     * @return Card
     */
    public function addScore(\AppBundle\Entity\Score $score)
    {
        $this->score[] = $score;

        return $this;
    }

    /**
     * Remove score.
     *
     * @param \AppBundle\Entity\Score $score
     */
    public function removeScore(\AppBundle\Entity\Score $score)
    {
        $this->score->removeElement($score);
    }

    /**
     * Get score.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set etablishment.
     *
     * @param \AppBundle\Entity\Etablishment $etablishment
     *
     * @return Card
     */
    public function setEtablishment(\AppBundle\Entity\Etablishment $etablishment)
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
     * Set command
     *
     * @param \AppBundle\Entity\Command $command
     *
     * @return Card
     */
    public function setCommand(\AppBundle\Entity\Command $command)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * Get command
     *
     * @return \AppBundle\Entity\Command
     */
    public function getCommand()
    {
        return $this->command;
    }
}
