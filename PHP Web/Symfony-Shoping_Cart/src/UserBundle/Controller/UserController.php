<?php

namespace UserBundle\Controller;

use IMG\ShopBundle\Entity\Cart;
use IMG\ShopBundle\Entity\FinalizedOrders;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Entity\User;

class UserController extends Controller
{

    /**
     * @Route("/", name="user_home")
     * @Template()
     */
    public function IndexAction()
    {
        return [];
    }
    /**
     * @Route("/profile", name="user_profile")
     * @Template()
     */
    public function ProfileAction()
    {
        return [];
    }
}
