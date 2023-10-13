<?php

namespace App\Controller\Main;

use App\Entity\Category;
use App\Utils\Manager\CategoryManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/{slug}", name="main_category_show")
     */
    public function show(CategoryManager $categoryManager, string $slug): Response
    {
        $category = $categoryManager->getRepository()->findOneBy(['slug' => $slug]);

        if (!$category) {
            throw new NotFoundHttpException();
        }

        $products = $category->getProducts()->getValues();

        return $this->render('main/category/show.html.twig', [
            'category' => $category,
            'products' => $products
        ]);
    }
}