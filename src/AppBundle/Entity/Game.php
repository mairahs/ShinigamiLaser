<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Game.
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GameRepository")
 */
class Game
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\GameType", cascade={"persist"})
     */
    private $gameType;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TimeSlot", cascade={"persist"})
     */
    private $timeSlot;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="played_at", type="datetime", nullable=true)
     */
    private $playedAt;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Score", mappedBy="games")
     */
    private $score;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Etablishment", inversedBy="games")
     */
    private $etablishment;

    /**
     * @var bool
     *
     * @ORM\Column (name="booking", type="boolean", nullable=true)
     */
    private $booking;

    /**
     * @var int
     *
     * @ORM\Column (name="nb_max", type="integer")
     */
    private $nb_max;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->score = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set playedAt.
     *
     * @param \DateTime $playedAt
     *
     * @return Game
     */
    public function setPlayedAt($playedAt)
    {
        $this->playedAt = $playedAt;

        return $this;
    }

    /**
     * Get playedAt.
     *
     * @return \DateTime
     */
    public function getPlayedAt()
    {
        return $this->playedAt;
    }

    /**
     * Set gameType.
     *
     * @param \AppBundle\Entity\GameType $gameType
     *
     * @return Game
     */
    public function setGameType(\AppBundle\Entity\GameType $gameType = null)
    {
        $this->gameType = $gameType;

        return $this;
    }

    /**
     * Get gameType.
     *
     * @return \AppBundle\Entity\GameType
     */
    public function getGameType()
    {
        return $this->gameType;
    }

    /**
     * Add score.
     *
     * @param \AppBundle\Entity\Score $score
     *
     * @return Game
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
     * @return Game
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
     * Get timeSlot.
     *
     * @return \AppBundle\Entity\TimeSlot
     */
    public function getTimeSlot()
    {
        return $this->timeSlot;
    }

    /**
     * Set timeSlot.
     *
     * @param \AppBundle\Entity\TimeSlot $timeSlot
     *
     * @return Game
     */
    public function setTimeSlot(\AppBundle\Entity\TimeSlot $timeSlot = null)
    {
        $this->timeSlot = $timeSlot;

        return $this;
    }

    /**
     * Set booking.
     *
     * @param bool $booking
     *
     * @return Game
     */
    public function setBooking($booking)
    {
        $this->booking = $booking;

        return $this;
    }

    /**
     * Get booking.
     *
     * @return bool
     */
    public function getBooking()
    {
        return $this->booking;
    }

    /**
     * Set nbMax.
     *
     * @param int $nbMax
     *
     * @return Game
     */
    public function setNbMax($nbMax)
    {
        $this->nb_max = $nbMax;

        return $this;
    }

    /**
     * Get nbMax.
     *
     * @return int
     */
    public function getNbMax()
    {
        return $this->nb_max;
    }
}
