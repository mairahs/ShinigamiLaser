<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Game
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
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=55)
     */
    private $type;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->score = new ArrayCollection();
    }

    /**
     * Add score
     *
     * @param \AppBundle\Entity\Score $score
     *
     * @return Game
     */
    public function addScore(Score $score)
    {
        $this->score[] = $score;

        return $this;
    }

    /**
     * Remove score
     *
     * @param \AppBundle\Entity\Score $score
     */
    public function removeScore(Score $score)
    {
        $this->score->removeElement($score);
    }

    /**
     * Get score
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Game
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set playedAt
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
     * Get playedAt
     *
     * @return \DateTime
     */
    public function getPlayedAt()
    {
        return $this->playedAt;
    }
}
