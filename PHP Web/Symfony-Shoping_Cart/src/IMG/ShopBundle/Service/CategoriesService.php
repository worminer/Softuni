<?php


namespace IMG\ShopBundle\Service;


use Doctrine\ORM\EntityManager;
use IMG\ShopBundle\Entity\Category;

class CategoriesService
{
    /**
     * @var EntityManager
     */
    private $_em;
    public function __construct(EntityManager $entityManager)
    {
        $this->_em = $entityManager;
    }
    public function getCategoriesService(){


        return $this->_em->getRepository(Category::class)->fetchCategories();
    }
}