<?php

namespace IMG\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CartItem
 *
 * @ORM\Table(name="cart_items")
 * @ORM\Entity(repositoryClass="IMG\ShopBundle\Repository\CartItemRepository")
 */
class CartItem
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
     * @var Item
     *  one cart item can be many other items
     * @ORM\ManyToOne(targetEntity="IMG\ShopBundle\Entity\Item", inversedBy="cardItem", cascade={"persist"})
     * @ORM\JoinColumn(name="cartitem_id", referencedColumnName="id")
     */
    private $item;

    /**
     * @var Cart
     * @ORM\ManyToOne(targetEntity="IMG\ShopBundle\Entity\Cart", inversedBy="items", cascade={"persist"})
     * @ORM\JoinColumn(name="cart_id", referencedColumnName="id")
     */
    private $cart;

    /**
     * @var int
     * @ORM\Column(name="quantity", type="integer", options={"default" = 0})
     */
    private $quantity;


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
     * Set item
     *
     * @param Item $item
     *
     * @return CartItem
     */
    public function setItem( Item $item)
    {
        $this->item = $item;

        return $this;
    }


    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return CartItem
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


}

