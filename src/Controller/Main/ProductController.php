<?php

namespace App\Controller\Main;

use App\Utils\Manager\ProductManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/{uuid}", name="main_product_show")
     */
    public function show(ProductManager $productManager, string $uuid): Response
    {
        $product = $productManager->getRepository()->findOneBy(['uuid' => $uuid]);
        if (!$product) {
            throw new NotFoundHttpException();
        }

        return $this->render('main/product/show.html.twig', [
            'product' => $product,
        ]);
    }
}