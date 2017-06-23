<?php

namespace IMG\ShopBundle\Controller;

use IMG\ShopBundle\Entity\Cart;
use IMG\ShopBundle\Entity\CartItem;
use IMG\ShopBundle\Entity\Category;
use IMG\ShopBundle\Entity\Item;
use IMG\ShopBundle\Form\BuyItemType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class FrontStoreController extends Controller
{

    /**
     * @Route("/", name="shop_index")
     * @Template()
     */
    public function indexAction()
    {
        $categories = $this->getDoctrine()->getManager()->getRepository(Category::class)->fetchCategories();

        return [
            'categories' => $categories,
        ];
    }

    /**
     * @Route("/shop/category/{id}", name="shop_category_items")
     * @Template()
     */
    public function ShowCategoryItemsAction ($id)
    {
        $categoryRepo = $this->getDoctrine()->getManager()->getRepository(Category::class);

        /** @var Category $category */
        $category = $categoryRepo->find($id);

        return [
            'current_category' => $category
        ];
    }

    /**
     * @Route("/shop/item/{id}", name="shop_view_item")
     * @Template()
     */
    public function ShowItemAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $item = $em->getRepository(Item::class)->find($id);
        $quantityInCard = 0;
        /** @var Cart $currentCart */
        if ($this->getUser() != null) {
            $currentCart = $em->getRepository(Cart::class)->fetchNewestCart($this->getUser());
            foreach ($currentCart->getItems()->getValues() as $cardItem){
                /** @var CartItem $cardItem */
                if ($cardItem->getItem()->getId() == $id) {
                    $quantityInCard = $cardItem->getQuantity();
                }
            }
        } else {
            $currentCart = new Cart();
        }

        $buyForm = $this->createForm(BuyItemType::class);

        return [
            'item' => $item,
            'buyForm' => $buyForm->createView(),
            'cartQuantity' => $quantityInCard,
        ];
    }
}
