<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GameType.
 *
 * @ORM\Table(name="game_type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GameTypeRepository")
 */
class GameType
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
     * @var bool
     *
     * @ORM\Column (name="team", type="boolean")
     */
    private $team;

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
     * Set type.
     *
     * @param string $type
     *
     * @return GameType
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    public function __toString()
    {
        return $this->getType();
    }

    /**
     * Set team.
     *
     * @param bool $team
     *
     * @return GameType
     */
    public function setTeam($team)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team.
     *
     * @return bool
     */
    public function getTeam()
    {
        return $this->team;
    }
}
