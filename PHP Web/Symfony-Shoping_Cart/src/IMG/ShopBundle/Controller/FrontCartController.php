<?php

namespace IMG\ShopBundle\Controller;


use IMG\ShopBundle\Entity\Cart;
use IMG\ShopBundle\Entity\CartItem;
use IMG\ShopBundle\Entity\FinalizedOrders;
use IMG\ShopBundle\Entity\Item;
use IMG\ShopBundle\Form\BuyItemType;
use IMG\ShopBundle\Form\PurchaseType;
use IMG\ShopBundle\Form\SetItemQiantityType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Cart Front controller.
 *
 * @Route("/cart")
 * @Security(expression="has_role('ROLE_USER')")
 */
class FrontCartController extends Controller
{
    /**
     * @Route("/", name="cart_show_items")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Cart $cart */
        $cart = $em->getRepository(Cart::class)->fetchNewestCart($this->getUser());

        $setQuantityForm = $this->createForm(SetItemQiantityType::class);
        $purchaseForm = $this->createForm(PurchaseType::class);
        $formArray = [];
        foreach ($cart->getItems()->getValues() as $cartItem) {
            /**@var $cartItem CartItem */
            $formArray[$cartItem->getId()] = $setQuantityForm->createView();
        }

        return [
            'cart' => $cart,
            'formArray' => $formArray,
            'purchaseForm' => $purchaseForm->createView(),
        ];
    }

    /**
     * @Route("/processItem", name="cart_process_item")
     * @Method(methods={"POST"})
     */
    public function processItemToCartAction(Request $request){
        $buyForm = $this->createForm(BuyItemType::class)->handleRequest($request);
        $formData = $buyForm->getData();

        $itemId = $formData['item_id'];
        $orderedQuantity = $formData['quantity'];

        $em = $this->getDoctrine()->getManager();

        $itemEntity = $em->getRepository(Item::class)->find($itemId);
        /** @var Cart $cart*/
        $cart= $em->getRepository(Cart::class)->fetchNewestCart($this->getUser());

        $currentCartItem = new CartItem();

        /** @var $currentCartItem CartItem */
        foreach ($cart->getItems()->getValues() as $oldCartItem) {
                /** @var $oldCartItem CartItem */
            if ($oldCartItem->getItem()->getId() == $itemId) {
                $currentCartItem = $oldCartItem;
            }
        }

        // because by default is null..
        if ($currentCartItem->getQuantity() === null) {
            $currentCartItem->setQuantity(0);

        }
        // just so i can display it later ..
        $quantityInCart = $currentCartItem->getQuantity();

        $currentCartItem
            ->setItem($itemEntity)
            ->setQuantity($orderedQuantity + $currentCartItem->getQuantity())
            ->setCart($cart)
        ;

        if ($itemEntity->getQuantity() < $currentCartItem->getQuantity()) {

            $this->addFlash(
                'error',
                "There are {$itemEntity->getQuantity()} items, but you try to order {$currentCartItem->getQuantity()} ({$quantityInCart} of them in the card) !"
            );
            return $this->redirectToRoute('shop_view_item',['id'=> $itemId]);
        }


        $em->persist($currentCartItem);
        $em->flush();

        return $this->redirectToRoute('cart_show_items');
    }

    /**
     * @Route("/change_item_quantity", name="cart_item_quantity_change")
     * @Method(methods={"POST"})
     */
    public function changeItemQuantityInCartAction(Request $request){
        $setItemQuantityForm = $this->createForm(SetItemQiantityType::class)->handleRequest($request);
        $formData = $setItemQuantityForm->getData();

        $cardItemId = $formData['card_item_id'];
        $quantity = $formData['quantity'];

        $em = $this->getDoctrine()->getManager();
        /** @var CartItem $cartItemEntity */
        $cartItemEntity = $em->getRepository(CartItem::class)->find($cardItemId);

        /** @var $currentCart Cart */
        $currentCart = $em->getRepository(Cart::class)->fetchNewestCart($this->getUser());

        if ($cartItemEntity->getCart()->getId() != $currentCart->getId()) {
            $this->addFlash(
                'error',
                "This item is not in your card!!! I see you there !!!"
            );
            return $this->redirectToRoute('cart_show_items');
        }

        $cartItemEntity->setQuantity($quantity);

        if ($cartItemEntity->getQuantity() < 1) {
            $em->remove($cartItemEntity);
            $em->flush();
            $this->addFlash(
                'success',
                "Item successfully removed from cart."
            );
            return $this->redirectToRoute('cart_show_items');
        }


        if ($cartItemEntity->getQuantity() > $cartItemEntity->getItem()->getQuantity()) {

            $this->addFlash(
                'error',
                "There are {$cartItemEntity->getItem()->getQuantity()} items, but you try to order {$cartItemEntity->getQuantity()} !"
            );
            return $this->redirectToRoute('cart_show_items');
        }

        $em->persist($cartItemEntity);
        $em->flush();

        return $this->redirectToRoute('cart_show_items');
    }

    /**
     * @Route("/remove_item/{id}", name="cart_remove_item")
     */
    public function removeItemFromCartAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $cartItemEntity = $em->getRepository(CartItem::class)->find($id);
        /** @var Cart $currentCart */
        $currentCart = $em->getRepository(Cart::class)->fetchNewestCart($this->getUser());
        if ($cartItemEntity->getCart()->getId() != $currentCart->getId()) {
            $this->addFlash(
                'error',
                "This item is not in your card!!! I see you there !!!"
            );
            return $this->redirectToRoute('cart_show_items');
        }
        $em->remove($cartItemEntity);
        $em->flush();

        $this->addFlash(
            'success',
            "Item successfully removed from cart."
        );
        return $this->redirectToRoute('cart_show_items');
    }

    /**
     * @Route("/order", name="cart_order_action")
     * @Method({"POST"})
     */
    public function orderAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $finalizedCartEntity = new FinalizedOrders();
        $currentCart = $em->getRepository(Cart::class)->fetchNewestCart($this->getUser());
        $orderItems = $currentCart->getItems()->getValues();
        if (count($orderItems) == 0 ) {
           return $this->redirectToRoute('shop_index');
        }
        $finalPrize = 0;
        foreach ($orderItems as $cartItem)
        {
            /** @var CartItem $cartItem */

            $realItem = $cartItem->getItem();
            if ($realItem->getQuantity() < $cartItem->getQuantity()) {
                $this->addFlash('error', "Item '{$realItem->getName()}' have quantity of {$realItem->getQuantity()} and you want to order {$cartItem->getQuantity()}. Please fix your order quantity and try again." );
                return $this->redirectToRoute('cart_show_items');

            }
            $prize = $cartItem->getQuantity() * $realItem->getPrice();
            $realItem->setQuantity($realItem->getQuantity() - $cartItem->getQuantity());
            $finalPrize += $prize;
            $em->persist($realItem);
        }
        $finalizedCartEntity->setFinalPrice($finalPrize);
        $finalizedCartEntity->setCartId($currentCart);
        $finalizedCartEntity->setFinalizedAt(new \DateTime());
        $em->persist($finalizedCartEntity);

        $em->getRepository(Cart::class)->createNewCard($this->getUser());
        $em->flush();

        $this->addFlash('success',
            'Your Order is Complete!'
        );

        return $this->redirectToRoute('shop_index');

    }
}
