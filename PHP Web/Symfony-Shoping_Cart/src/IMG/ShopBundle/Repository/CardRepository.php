<?php

namespace IMG\ShopBundle\Repository;
use IMG\ShopBundle\Entity\Cart;
use UserBundle\Entity\User;


/**
 * CardRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CardRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param User $user
     * @return Cart
     */
    public function fetchNewestCart(User $user)
    {
        $qb= $this->createQueryBuilder('c')
            ->leftJoin('c.items','i')
        ->where('c.user = :user')
        ->setParameter('user', $user)
        ->orderBy('c.createdAt','desc')
        ->setMaxResults(1);
        $result = $qb->getQuery()->getOneOrNullResult();
        // its text null.. because whateva ..
        if ($result == null) {
            $result = $this->createNewCard($user);
            dump($user);
        }

        return $result;
    }

    /**
     * @param User $user
     * @return Cart
     */
    public function createNewCard(User $user)
    {

        $em = $this->getEntityManager();
        $cart = new Cart();
        $cart->setCreatedAt(new \DateTime());
        $cart->setUser($user);

        $em->persist($cart);
        $em->flush();
        return $cart;
    }
}
