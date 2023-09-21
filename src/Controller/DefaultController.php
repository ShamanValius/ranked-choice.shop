<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Form\EditProductFormType;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        return $this->render('main/default/index.html.twig', []);
    }

    /**
     * @Route("/edit-product/{id}", name="product_edit", requirements={"id"="\d+"})
     * @Route("/add-product", name="product_add")
     */
    public function productEdit( Request $request, int $id = null): Response
    {
        $entityManager = $this -> getDoctrine()->getManager();

        if($id){
            $product = $entityManager->getRepository(Product::class)->find($id);
        }
        else{
            $product = new Product();
        }

        $form = $this -> createForm(EditProductFormType::class, $product);
        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid()){

            $data = $form -> getData();

            $entityManager -> persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_edit', ['id' => $product -> getId()]);
        }

        return $this->render('main/default/edit_product.html.twig', [
            'form' => $form -> createView()
        ]);
    }

}
