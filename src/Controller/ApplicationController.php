<?php

namespace App\Controller;

use App\Repository\ApplicationRepository;
use App\Repository\PagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ApplicationController extends AbstractController
{
    #[Route('/application', name: 'app_application')]
    public function index(ApplicationRepository $applicationRepository, PagesRepository $pagesRepository): Response
    {
        $page = $pagesRepository->findOneBy(['name' => 'contact us']);
        $applications = $applicationRepository->findAll();
        return $this->render('application/index.html.twig', [
            'applications' => $applications,
            'page' => $page,
        ]);
    }
}
