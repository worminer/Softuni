<?php

namespace IMG\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * finalizedOrders
 *
 * @ORM\Table(name="finalized_orders")
 * @ORM\Entity(repositoryClass="IMG\ShopBundle\Repository\finalizedOrdersRepository")
 */
class FinalizedOrders
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
     * @var \DateTime
     *
     * @ORM\Column(name="finalized_on", type="datetime")
     */
    private $finalizedAt;

    /**
     * @var string
     * @ORM\Column(name="price", type="decimal", precision=11, scale=2)
     */
    private $finalPrice;

    /**
     * @var Cart
     *
     * @ORM\ManyToOne(targetEntity="IMG\ShopBundle\Entity\Cart", inversedBy="finalizedOrder")
     * @ORM\JoinColumn(name="cart_id", referencedColumnName="id")
     */
    private $cartId;

    /** @var User
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="finalizedOrders")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;


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
     * Set finalizedOn
     *
     * @param \DateTime $finalizedAt
     *
     * @return FinalizedOrders
     */
    public function setFinalizedAt($finalizedAt)
    {
        $this->finalizedAt = $finalizedAt;

        return $this;
    }

    /**
     * Get finalizedOn
     *
     * @return \DateTime
     */
    public function getFinalizedAt()
    {
        return $this->finalizedAt;
    }

    /**
     * Set cartId
     *
     * @param integer $cartId
     *
     * @return FinalizedOrders
     */
    public function setCartId($cartId)
    {
        $this->cartId = $cartId;

        return $this;
    }

    /**
     * Get cartId
     *
     * @return Cart
     */
    public function getCartId()
    {
        return $this->cartId;
    }

    /**
     * @return string
     */
    public function getFinalPrice()
    {
        return $this->finalPrice;
    }

    /**
     * @param string $finalPrice
     */
    public function setFinalPrice($finalPrice)
    {
        $this->finalPrice = $finalPrice;
    }



}

