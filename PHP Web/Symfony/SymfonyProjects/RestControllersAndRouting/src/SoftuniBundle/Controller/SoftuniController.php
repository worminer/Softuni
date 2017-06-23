<?php

namespace SoftuniBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SoftuniBundle\Entity\Article;
use SoftuniBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SoftuniController extends Controller
{
    /**
     * @Route("/upload", name="upload")
     */
    public function uploadAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class,$article);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $doctrine = $this->getDoctrine()->getManager();

            $doctrine->persist($article);
            $doctrine->flush();
        }

        return $this->render('softuni/upload-form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
