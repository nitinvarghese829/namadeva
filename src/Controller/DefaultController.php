<?php

namespace App\Controller;

use App\Entity\Enquiry;
use App\Entity\Pages;
use App\Form\EnquiryFormType;
use App\Repository\BlogsRepository;
use App\Repository\PagesRepository;
use App\Repository\ProductRepository;
use App\Service\EmailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(ProductRepository $productRepository, PagesRepository $pagesRepository, BlogsRepository $blogsRepository): Response
    {
        $page = $pagesRepository->findOneBy(['name' => 'home']);
        $products = $productRepository->findBy(['isTrending' => 1]);
        $blogs = $blogsRepository->findRandomBlogs(3);
        return $this->render('default/index.html.twig', [
            'products' => $products,
            'page' => $page,
            'blogs' => $blogs,
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
    public function contactUs(Request $request, EntityManagerInterface $entityManager, PagesRepository $pagesRepository, EmailerService $emailerService): Response
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

            $subject = 'New Enquiry from ' . $page->getName();
            $body = '
            <p>Name: ' . $form->get('firstname')->getData() . ' ' . $form->get('lastname')->getData() . '</p>
            <p>Email: ' . $form->get('email')->getData() . '</p>
            <p>Phone: ' . $form->get('phone')->getData() . '</p>
            <p>Pincode: ' . $form->get('pincode')->getData() . '</p>
            <p>Message: ' . $form->get('requirement')->getData() . '</p>
            <p>Product: '. $form->get('product')->getData()->getName() .'</p>
            ';
            $emailerService->sendEmail($body, $subject);
            return $this->redirectToRoute('app_contact_us');
        }

        return $this->render('default/contact-us.html.twig', [
            'form' => $form->createView(),
            'page' => $page,
        ]);
    }

}
