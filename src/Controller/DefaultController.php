<?php

namespace App\Controller;

use App\Entity\Enquiry;
use App\Entity\Pages;
use App\Form\EnquiryFormType;
use App\Repository\BlogsRepository;
use App\Repository\PagesRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(ProductRepository $productRepository, PagesRepository $pagesRepository): Response
    {
        $page = $pagesRepository->findOneBy(['name' => 'home']);
        $products = $productRepository->findBy(['isTrending' => 1]);
        return $this->render('default/index.html.twig', [
            'products' => $products,
            'page' => $page,
        ]);
    }

    #[Route('/about-us', name: 'app_about_us')]
    public function aboutUs(PagesRepository $pagesRepository): Response
    {
        $page = $pagesRepository->findOneBy(['name' => 'about us']);
        return $this->render('default/about-us.html.twig', [
            'page' => $page,
        ]);
    }

    #[Route('/knowledge-hub', name: 'app_knowledge_hub')]
    public function knowledgeHub(PagesRepository $pagesRepository): Response
    {
        $page = $pagesRepository->findOneBy(['name' => 'about us']);
        return $this->render('knowledge-hub/knowledgeHub.html.twig', [
            'page' => $page,
        ]);
    }

    #[Route('/knowledge-hub/blogs', name: 'app_knowledge_hub_blogs')]
    public function knowledgeHubBlogs(PagesRepository $pagesRepository, BlogsRepository $blogsRepository): Response
    {
        $blogs = $blogsRepository->findAll();
        $page = $pagesRepository->findOneBy(['name' => 'about us']);
        return $this->render('knowledge-hub/blogs.html.twig', [
            'page' => $page,
            'blogs' => $blogs,
        ]);
    }

    #[Route('/knowledge-hub/blogs/{slug}', name: 'app_knowledge_hub_blogs_blog')]
    public function blog(PagesRepository $pagesRepository, BlogsRepository $blogsRepository, $slug = null): Response
    {
        $blog = $blogsRepository->findOneBy(['slug' => $slug]);
        $randomBlogs = $blogsRepository->findRandomBlogs(3);

        $page = $pagesRepository->findOneBy(['name' => 'about us']);
        return $this->render('knowledge-hub/blog.html.twig', [
            'page' => $page,
            'blog' => $blog,
            'randomBlogs' => $randomBlogs,
        ]);
    }

    #[Route('/contact-us', name: 'app_contact_us')]
    public function contactUs(Request $request, EntityManagerInterface $entityManager, PagesRepository $pagesRepository): Response
    {
        $page = $pagesRepository->findOneBy(['name' => 'contact us']);
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
            'form' => $form->createView(),
            'page' => $page,
        ]);
    }
}
