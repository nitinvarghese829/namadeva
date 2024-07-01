<?php

namespace App\Controller;

use App\Repository\ProductCategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/products', name: 'app_product_')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProductRepository $productRepository, ProductCategoryRepository $productCategoryRepository): Response
    {
        $products = [];
        $categories = $productCategoryRepository->findAll();
        foreach ($categories as $category){
            $products[$category->getSlug()] = $productRepository->findBy(['category' => $category]);
        }
        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }
}
