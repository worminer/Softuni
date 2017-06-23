<?php

namespace UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use IMG\ShopBundle\Entity\Cart;
use IMG\ShopBundle\Entity\Item;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 * @UniqueEntity(
 *      fields={"username"},
 *      message="This username already exist. Please choose another one.."
 * )
 * @UniqueEntity(
 *      fields={"email"},
 *      message="This Email already exist. Did you forgot that you are already registered?"
 * )
 */
class User implements UserInterface
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
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     * @Assert\NotBlank(
     *     message="Username cannot be empty!"
     * )
     * @Assert\Length(
     *     min="5",
     *     minMessage="Username cannot be less then {{ limit }} symbols!"
     * )
     *
     *
     */
    private $username;

    /**
     * @var string
     * @ORM\Column(name="display_name", type="string", length=255, unique=true)
     * @Assert\NotBlank(
     *     message="Display name cannot be empty!"
     * )
     * @Assert\Length(
     *     min="5",
     *     minMessage="Display name cannot be less then {{ limit }} symbols!"
     * )
     *
     *
     */
    private $displayName;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\Email(
     *     message="This is not an valid email address."
     * )
     * @Assert\NotBlank(
     *     message="Email cannot be empty!"
     * )
     */
    private $email;


    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @Assert\Length(min="5")
     */
    private $password_raw;

    /**
     * @var Item[]
     * @ORM\OneToMany(targetEntity="IMG\ShopBundle\Entity\Item", mappedBy="user")
     */
    private $items;

    /**
     * @var Role[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\Role",indexBy="users", inversedBy="users")
     * @ORM\JoinTable(name="user_roles", joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}, inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")})
     */
    private $roles;


    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

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
     * Set username
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Returns the roles granted to the user.
     * @return Role[]|string[] The user roles
     */
    public function getRoles()
    {
        return array_map(function(Role $roles) {
            return $roles->getName();
        }, $this->roles->toArray());
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function addRole(Role $role){
        $this->roles->add($role);
    }

    /**
     * @return Collection|Item[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param Collection|Item[] $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    public function addItem(Item $item)
    {
        $this->getItems()->add($item);
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @param string $displayName
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }

    /**
     * @return mixed
     */
    public function getPasswordRaw()
    {
        return $this->password_raw;
    }

    /**
     * @param $password_raw
     * @internal param mixed $password__raw
     */
    public function setPasswordRaw($password_raw)
    {
        $this->password_raw = $password_raw;
    }

    /**
     * @return Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @param Cart $cart
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
    }

    public function __toString()
    {
       return $this->getUsername();
    }


}

