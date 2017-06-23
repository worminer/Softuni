<?php

namespace IMG\ShopBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category
 *
 * @ORM\Table(name="categories")
 * @ORM\Entity(repositoryClass="IMG\ShopBundle\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Assert\NotBlank(
     *     message="Category name cannot be empty!"
     * )
     * @Assert\Length(
     *     min="3",
     *     minMessage="Category name should be 3 letters or more."
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text")
     * @Assert\NotBlank(
     *     message="Category Description cannot be empty!"
     * )
     * @Assert\Length(
     *     min="5",
     *     minMessage="Category Description should be 3 letters or more."
     * )
     */
    private $description;

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
     * @var Item[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="IMG\ShopBundle\Entity\Item", mappedBy="categories", cascade={"persist"})
     */
    private $items;

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
     * @return Category
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
     * @return Category
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

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return ArrayCollection|Item[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param ArrayCollection|Item[] $items
     */
    public function setItems($items)
    {
        $this->items = $items;
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

    /**
     * @param mixed $front_image
     */
    public function setFrontImage($front_image)
    {
        $this->front_image = $front_image;
    }


}

