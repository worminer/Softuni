<?php

namespace IMG\ShopBundle\Entity;

use Doctrine\Common\Annotations\Annotation\Required;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use UserBundle\Entity\User;

/**
 * Item
 *
 * @ORM\Table(name="items")
 * @ORM\Entity(repositoryClass="IMG\ShopBundle\Repository\ItemRepository")
 */
class Item
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
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank(message="Title cannot be blank!")
     * @Assert\Length(
     *     max="255",
     *     min="5",
     *     maxMessage="Title is to long,it should be less then {{ limit }}!",
     *     minMessage="Title is to short, it should be more then {{ limit }}!"
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Assert\NotBlank(message="Description cannot be blank!");
     * @Assert\Length(
     *     min="5",
     *     minMessage="Description should be more then {{ limit }} symbols!"
     * )
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=11, scale=2)
     * @Assert\NotBlank(message="Price cannot be blank!")
     * @Assert\GreaterThan(value="0", message="Price cannot be negative number! ")
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     * @Assert\NotBlank(message="Quantity cannot be blank!")
     * @Assert\GreaterThan(value="0", message="Quantity cannot be negative number!")
     */
    private $quantity;

    /**
     * @Assert\Image(
     *     mimeTypes={"image/png", "image/jpeg"},
     *     mimeTypesMessage="This format is not allowed!Only PNG or JPG format!",
     *     maxSize="5M"
     * )
     */
    private $front_image_file;

    /**
     * @ORM\Column(name="front_image", type="string", length=255 , nullable=true)
     */
    private $front_image;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expires_at", type="datetime")
     * @Assert\GreaterThan("today")
     */
    private $expiresAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="expireble", type="boolean")
     */
    private $expireble;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_deleted", type="boolean")
     */
    private $isDeleted;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="items")
     * @ORM\JoinColumn(name="user_id")
     *
     */
    private $user;

    /**
     * @var CartItem
     * one item can be many cart items
     * @ORM\OneToMany(targetEntity="IMG\ShopBundle\Entity\CartItem", mappedBy="item", indexBy="id")
     *
     */
    private $cardItem;

    /**
     * @var Category[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="IMG\ShopBundle\Entity\Category", inversedBy="items", cascade={"persist"})
     * @ORM\JoinTable(name="category_items", joinColumns={@ORM\JoinColumn(name="item_id", referencedColumnName="id")}, inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")})
     */
    private $categories;

    /**
     * @return ArrayCollection|Category[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param ArrayCollection|Category[] $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * Item constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->isDeleted = false;
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
     * Set name
     *
     * @param string $name
     *
     * @return Item
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Item
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Item
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Item
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return mixed
     */
    public function getFrontImageFile()
    {
        return $this->front_image_file;
    }

    /**
     * @param mixed $front_image_file
     */
    public function setFrontImageFile($front_image_file)
    {
        $this->front_image_file = $front_image_file;
    }

    /**
     * @return mixed
     */
    public function getFrontImage()
    {
        return $this->front_image;
    }


    public function setFrontImage($front_image)
    {
        if($front_image !== null) {
            $this->front_image = $front_image;

            return $this;
        }
       // $this->front_image = $front_image;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Item
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set expiresAt
     *
     * @param \DateTime $expiresAt
     *
     * @return Item
     */
    public function setExpiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    /**
     * Get expiresAt
     *
     * @return \DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * Set expireble
     *
     * @param boolean $expireble
     *
     * @return Item
     */
    public function setExpireble($expireble)
    {
        $this->expireble = $expireble;

        return $this;
    }

    /**
     * Get expireble
     *
     * @return bool
     */
    public function getExpireble()
    {
        return $this->expireble;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     *
     * @return Item
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return bool
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getCardItem()
    {
        return $this->cardItem;
    }

    /**
     * @param mixed $cardItem
     */
    public function setCardItem($cardItem)
    {
        $this->cardItem = $cardItem;
    }

    public function __toString()
    {
        return $this->name;
    }

}

