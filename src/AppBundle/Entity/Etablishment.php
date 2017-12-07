<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etablishment.
 *
 * @ORM\Table(name="etablishment")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EtablishmentRepository")
 */
class Etablishment
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
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="code", type="integer")
     */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Game", mappedBy="etablishment")
     */
    private $games;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Command", mappedBy="etablishment")
     */
    private $commands;

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
     * Set city.
     *
     * @param string $city
     *
     * @return Etablishment
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city.
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Etablishment
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set code.
     *
     * @param int $code
     *
     * @return Etablishment
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code.
     *
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Add game.
     *
     * @param \AppBundle\Entity\Game $game
     *
     * @return Etablishment
     */
    public function addGame(\AppBundle\Entity\Game $game)
    {
        $this->games[] = $game;

        return $this;
    }

    /**
     * Remove game.
     *
     * @param \AppBundle\Entity\Game $game
     */
    public function removeGame(\AppBundle\Entity\Game $game)
    {
        $this->games->removeElement($game);
    }

    /**
     * Get games.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGames()
    {
        return $this->games;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->games = new \Doctrine\Common\Collections\ArrayCollection();
        $this->commands = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add command.
     *
     * @param \AppBundle\Entity\Command $command
     *
     * @return Etablishment
     */
    public function addCommand(\AppBundle\Entity\Command $command)
    {
        $this->commands[] = $command;

        return $this;
    }

    /**
     * Remove command.
     *
     * @param \AppBundle\Entity\Command $command
     */
    public function removeCommand(\AppBundle\Entity\Command $command)
    {
        $this->commands->removeElement($command);
    }

    /**
     * Get commands.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommands()
    {
        return $this->commands;
    }
}
