<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Score
 *
 * @ORM\Table(name="score")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ScoreRepository")
 */
class Score
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
     * @ORM\Column(name="result", type="integer")
     */
    private $result;

    /**
     * @var string
     *
     * @ORM\Column(name="rank", type="string", length=255)
     */
    private $rank;

    /**
     * @var int
     *
     * @ORM\Column(name="team", type="integer")
     */
    private $team;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Player", inversedBy="score", cascade={"persist"})
     */
    private $players;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Game", inversedBy="score", cascade={"persist"})
     */
    private $games;

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
     * Set result
     *
     * @param integer $result
     *
     * @return Score
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result
     *
     * @return int
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set rank
     *
     * @param string $rank
     *
     * @return Score
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return string
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set team
     *
     * @param integer $team
     *
     * @return Score
     */
    public function setTeam($team)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team
     *
     * @return int
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set players
     *
     * @param \AppBundle\Entity\Player $players
     *
     * @return Score
     */
    public function setPlayers(Player $players = null)
    {
        $this->players = $players;

        return $this;
    }

    /**
     * Get players
     *
     * @return \AppBundle\Entity\Player
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * Set games
     *
     * @param \AppBundle\Entity\Game $games
     *
     * @return Score
     */
    public function setGames(Game $games = null)
    {
        $this->games = $games;

        return $this;
    }

    /**
     * Get games
     *
     * @return \AppBundle\Entity\Game
     */
    public function getGames()
    {
        return $this->games;
    }
}
