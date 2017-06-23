<?php

namespace IMG\ShopBundle\Controller;

use IMG\ShopBundle\Entity\Category;
use IMG\ShopBundle\Entity\Item;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * Item controller.
 *
 * @Route("items")
 *@Security(expression="has_role('ROLE_SHOPMOD') or has_role('ROLE_ADMIN')")
 */
class ItemController extends Controller
{

    /**
     * Lists all Item entities.
     * @Route("/", name="item_manage")
     * @Template()
     * @Method("GET")
     */
    public function ManageAction()
    {
        $em = $this->getDoctrine()->getManager();

        $items = $em->getRepository(Item::class)->findAll();

        return [
            'items' => $items
        ];
    }

    /**
     * Creates a new Item entity.
     *
     * @Route("/new", name="item_new")
     * @Template()
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response|array
     */
    public function newAction(Request $request)
    {
        $item = new Item();
        $item->setExpiresAt(new \DateTime('+1 month'));

        $categories = $this->getDoctrine()->getManager()->getRepository(Category::class)->findAll();


        $form = $this->createForm('IMG\ShopBundle\Form\ItemType', $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($item->getFrontImageFile() instanceof UploadedFile) {
                //dealing with the image Upload
                /** @var UploadedFile $frontImageFile*/
                $frontImageFile = $item->getFrontImageFile();

                $frontImageFilename = md5($item->getName() .''. $item->getCreatedAt()->format('YmdHis'));
                // for some weird for me, reason I had to do this hack so the file extension can be added properly..
                $frontImageFilename = $frontImageFilename .'.'.  $frontImageFile->getClientOriginalExtension();
                // TODO:Maybe create utill for that !! it changes the path so it will work on windows and unix.. bullshit!!
                $imagesDirectory = '\\..\web\resources\images\shop\items';
                $imagesDirectory = str_replace('\\',DIRECTORY_SEPARATOR,$imagesDirectory);
                $imagesDirectory = str_replace('/',DIRECTORY_SEPARATOR,$imagesDirectory);
                // there is no proper way to get the WEB directory path .. WTF
                // also i am not sure if real path will make the proper path for unix .. but ..
                $frontImageFullPath = realpath($this->get('kernel')->getRootDir() .$imagesDirectory);
                $frontImageFile->move($frontImageFullPath,$frontImageFilename);

                $item->setFrontImage($frontImageFilename);
            }
            $item->setUser($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            return $this->redirectToRoute('item_manage', array('id' => $item->getId()));
        }

        return [
            'item' => $item,
            'item_form' => $form->createView(),
        ];
    }

    /**
     * Finds and displays a Item entity.
     *
     * @Route("/{id}", name="item_show")
     * @Template()
     * @Method("GET")
     * @param Item $item
     * @return \Symfony\Component\HttpFoundation\Response|array
     */
    public function showAction(Item $item)
    {
        $deleteForm = $this->createDeleteForm($item);

        return [
            'item' => $item,
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Displays a form to edit an existing Item entity.
     *
     * @Route("/{id}/edit", name="item_edit")
     * @Template()
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Item $item
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request, Item $item)
    {
        // check if user is author.. but there must be better way
        // TODO:check for better way to do this !
        // TODO:Deprecated
//        if ($this->getUser()->getId() != $item->getUser()->getId()) {
//            $this->addFlash("error", "You are not allowed to edit this item!");
//            return $this->redirectToRoute('item_manage');
//        }

        $deleteForm = $this->createDeleteForm($item);
        $editForm = $this->createForm('IMG\ShopBundle\Form\ItemType', $item);
        $editForm->handleRequest($request);



        if ($editForm->isSubmitted() && $editForm->isValid()) {

            if ($item->getFrontImageFile() instanceof UploadedFile) {
                //dealing with the image Upload
                /** @var UploadedFile $frontImageFile*/
                $frontImageFile = $item->getFrontImageFile();

                $frontImageFilename = md5($item->getName() .''. $item->getCreatedAt()->format('YmdHis'));
                // for some weird for me, reason I had to do this hack so the file extension can be added properly..
                $frontImageFilename = $frontImageFilename .'.'.  $frontImageFile->getClientOriginalExtension();
                // TODO:Maybe create utill for that !! it changes the path so it will work on windows and unix.. bullshit!!
                $imagesDirectory = '\\..\web\resources\images\shop\items';
                $imagesDirectory = str_replace('\\',DIRECTORY_SEPARATOR,$imagesDirectory);
                $imagesDirectory = str_replace('/',DIRECTORY_SEPARATOR,$imagesDirectory);
                // there is no proper way to get the WEB directory path .. WTF
                // also i am not sure if real path will make the proper path for unix .. but ..
                $frontImageFullPath = realpath($this->get('kernel')->getRootDir() .$imagesDirectory);
                $frontImageFile->move($frontImageFullPath,$frontImageFilename);

                $item->setFrontImage($frontImageFilename);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            return $this->redirectToRoute('item_manage');
        }
        return [
            'item' => $item,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Deletes a Item entity.
     *
     * @Route("/{id}", name="item_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Item $item
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Item $item)
    {
        // check if user is author.. but there must be better way
        // TODO:check for better way to do this !
        // TODO: DEPRECATED
//        if ($this->getUser()->getId() != $item->getUser()->getId()) {
//            $this->addFlash("error", "You are not allowed to edit this item!");
//            return $this->redirectToRoute('item_manage');
//        }

        $form = $this->createDeleteForm($item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($item);
            $em->flush();
        }

        return $this->redirectToRoute('item_manage');
    }

    /**
     * Creates a form to delete a Item entity.
     *
     * @param Item $item The Item entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Item $item)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('item_delete', array('id' => $item->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
