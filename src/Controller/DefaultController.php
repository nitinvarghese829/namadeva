<?php

namespace App\Controller;

use App\Entity\Enquiry;
use App\Form\EnquiryFormType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findBy(['isTrending' => 1]);
        return $this->render('default/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/about-us', name: 'app_about_us')]
    public function aboutUs(): Response
    {
        return $this->render('default/about-us.html.twig', []);
    }

    #[Route('/contact-us', name: 'app_contact_us')]
    public function contactUs(Request $request, EntityManagerInterface $entityManager): Response
    {
        $enquiry = new Enquiry();
        $form = $this->createForm(EnquiryFormType::class, $enquiry);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Save the enquiry to the database or perform any action
            // For example:
             $entityManager->persist($enquiry);
             $entityManager->flush();

            // Add a flash message or redirect to a 'thank you' page
            $this->addFlash('success', 'Enquiry submitted successfully!');

            return $this->redirectToRoute('app_contact_us');
        }

        return $this->render('default/contact-us.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
