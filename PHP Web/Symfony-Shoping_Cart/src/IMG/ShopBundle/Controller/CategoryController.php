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
 * Category controller.
 *
 * @Route("categories")
 * @Security(expression="has_role('ROLE_SHOPMOD') or has_role('ROLE_ADMIN')")
 */
class CategoryController extends Controller
{
    /**
     * Lists all Category entities.
     *
     * @Route("/", name="categories_manage")
     * @Template()
     * @Method("GET")
     */
    public function ManageAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('IMGShopBundle:Category')->findAll();
        return [
            'categories' => $categories,
        ];

    }

    /**
     * Creates a new Category entity.
     *
     * @Route("/new", name="categories_new")
     * @Template()
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm('IMG\ShopBundle\Form\CategoryType', $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('categories_show', array('id' => $category->getId()));
        }

        return [
            'Category' => $category,
            'create_category_form' => $form->createView(),
        ];
    }

    /**
     * Finds and displays a Category entity.
     *
     * @Route("/{id}", name="categories_show")
     * @Template()
     * @Method("GET")
     * @param Category $category
     * @return array
     */
    public function showAction(Category $category)
    {
        $deleteForm = $this->createDeleteForm($category);

        return [
            'category' => $category,
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     * @Route("/{id}/edit", name="categories_edit")
     * @Template()
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Category $category
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request, Category $category)
    {
        $deleteForm = $this->createDeleteForm($category);
        $editForm = $this->createForm('IMG\ShopBundle\Form\CategoryType', $category);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            if ($category->getFrontImageFile() instanceof UploadedFile) {
                //dealing with the image Upload
                /** @var UploadedFile $frontImageFile*/
                $frontImageFile = $category->getFrontImageFile();

                $frontImageFilename = md5($category->getName() .''. $category->getId());
                // for some weird for me, reason I had to do this hack so the file extension can be added properly..
                $frontImageFilename = $frontImageFilename .'.'.  $frontImageFile->getClientOriginalExtension();
                // TODO:Maybe create utill for that !! it changes the path so it will work on windows and unix.. bullshit!!
                $imagesDirectory = '\\..\web\resources\images\shop\categories';
                $imagesDirectory = str_replace('\\',DIRECTORY_SEPARATOR,$imagesDirectory);
                $imagesDirectory = str_replace('/',DIRECTORY_SEPARATOR,$imagesDirectory);
                // there is no proper way to get the WEB directory path .. WTF
                // also i am not sure if real path will make the proper path for unix .. but ..
                $frontImageFullPath = realpath($this->get('kernel')->getRootDir() .$imagesDirectory);
                $frontImageFile->move($frontImageFullPath,$frontImageFilename);

                $category->setFrontImage($frontImageFilename);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categories_manage');
        }

        return [
            'Category' => $category,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Deletes a Category entity.
     *
     * @Route("/{id}", name="categories_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Category $category)
    {
        $form = $this->createDeleteForm($category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();
        }

        return $this->redirectToRoute('categories_manage');
    }

    /**
     * Creates a form to delete a Category entity.
     *
     * @param Category $category The Category entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Category $category)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categories_delete', array('id' => $category->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
