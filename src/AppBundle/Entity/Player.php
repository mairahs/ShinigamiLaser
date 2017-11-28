<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Player.
 *
 * @ORM\Table(name="player")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlayerRepository")
 */
class Player implements UserInterface, \Serializable
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
     * @Assert\NotBlank()
     * @Assert\Length(max = 55)
     * @Assert\Regex(
     *     pattern="/^([a-zàáâäçèéêëìíîïñòóôöùúûü]+(( |')[a-zàáâäçèéêëìíîïñòóôöùúûü]+)*)+([-]([a-zàáâäçèéêëìíîïñòóôöùúûü]+(( |')[a-zàáâäçèéêëìíîïñòóôöùúûü]+)*)+)*$/iu",
     *     match=true
     * )
     *
     * @ORM\Column(name="firstname", type="string", length=55)
     */
    private $firstname;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max = 55)
     * @Assert\Regex(
     *     pattern="/^([a-zàáâäçèéêëìíîïñòóôöùúûü]+(( |')[a-zàáâäçèéêëìíîïñòóôöùúûü]+)*)+([-]([a-zàáâäçèéêëìíîïñòóôöùúûü]+(( |')[a-zàáâäçèéêëìíîïñòóôöùúûü]+)*)+)*$/iu",
     *     match=true
     * )
     *
     * @ORM\Column(name="lastname", type="string", length=55)
     */
    private $lastname;

    /**
     * @var string
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 55
     * )
     *
     * @ORM\Column(name="username", type="string", length=55, unique=true)
     */
    private $username;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max = 55)
     *
     * @ORM\Column(name="phone_number", type="string", length=55)
     */
    private $phoneNumber;

    /**
     * @var \DateTime
     * @Assert\NotBlank()
     * @Assert\DateTime()
     *
     * @ORM\Column(name="date_of_birth", type="datetime")
     */
    private $dateOfBirth;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 55
     * )
     * @Assert\Email()
     *
     * @ORM\Column(name="email", type="string", length=55)
     */
    private $email;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 255
     * )
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Card", mappedBy="player")
     */
    private $cards;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Avatar", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $avatar;

    /**
     * @var int
     *
     * @ORM\Column(name="token", type="string", length=255)
     */
    private $token;

    /**
     * @var bool
     *
     * @ORM\Column (name="is_activate", type="boolean", nullable=true)
     */
    private $isActivate;

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
     * Set firstname.
     *
     * @param string $firstname
     *
     * @return Player
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname.
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname.
     *
     * @param string $lastname
     *
     * @return Player
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname.
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set address.
     *
     * @param string $address
     *
     * @return Player
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address.
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set username.
     *
     * @param string $username
     *
     * @return Player
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set phoneNumber.
     *
     * @param string $phoneNumber
     *
     * @return Player
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber.
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set dateOfBirth.
     *
     * @param \DateTime $dateOfBirth
     *
     * @return Player
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth.
     *
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return Player
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return Player
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->cards = new ArrayCollection();
    }

    /**
     * Add card.
     *
     * @param Card $card
     *
     * @return Player
     */
    public function addCard(Card $card)
    {
        $this->cards[] = $card;

        return $this;
    }

    /**
     * Remove card.
     *
     * @param Card $card
     */
    public function removeCard(Card $card)
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

    /**
     * Set avatar.
     *
     * @param \AppBundle\Entity\Avatar $avatar
     *
     * @return Player
     */
    public function setAvatar(Avatar $avatar = null)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar.
     *
     * @return \AppBundle\Entity\Avatar
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set token.
     *
     * @param int $token
     *
     * @return Player
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token.
     *
     * @return int
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set isActivate.
     *
     * @param bool $isActivate
     *
     * @return Player
     */
    public function setIsActivate($isActivate)
    {
        $this->isActivate = $isActivate;

        return $this;
    }

    /**
     * Get isActivate.
     *
     * @return bool
     */
    public function getIsActivate()
    {
        return $this->isActivate;
    }

    /**
     * String representation of object.
     *
     * @see http://php.net/manual/en/serializable.serialize.php
     *
     * @return string the string representation of the object or null
     *
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize([
            $this->id,
        ]);
    }

    /**
     * Constructs the object.
     *
     * @see http://php.net/manual/en/serializable.unserialize.php
     *
     * @param string $serialized <p>
     *                           The string representation of the object.
     *                           </p>
     *
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list(
            $this->id
            ) = unserialize($serialized);
    }
}
