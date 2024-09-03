<?php

namespace App\Controller;

use App\Entity\Enquiry;
use App\Form\EnquiryFormType;
use App\Repository\ProductCategoryRepository;
use App\Repository\ProductRepository;
use App\Service\EmailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route('/{slug}', name: 'detail')]
    public function productDetailPage(ProductRepository $productRepository, Request $request, EntityManagerInterface $entityManager, EmailerService $emailerService, $slug): Response
    {
        $product = $productRepository->findOneBy(['slug' => $slug]);

        $products = $productRepository->findBy(['isTrending' => 1]);
        $enquiry = new Enquiry();
        $form = $this->createForm(EnquiryFormType::class, $enquiry,[
            'product' => $product,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($enquiry);
            $entityManager->flush();

            $this->addFlash('success', 'Enquiry submitted successfully!');

            $subject = 'New Enquiry from ' . $product->getName();
            $body = 'Phone: ' . $form->get('phone')->getData() . PHP_EOL . 'Product: '. $form->get('product')->getData()->getName();

            $emailerService->sendEmail($body, $subject);
            return $this->redirectToRoute('app_product_detail', ['slug' => $product->getSlug()]);
        }
        return $this->render('product/detail.html.twig', [
            'form' => $form->createView(),
            'product' => $product,
            'products' => $products,
        ]);
    }
}
