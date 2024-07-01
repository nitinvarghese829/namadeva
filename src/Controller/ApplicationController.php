<?php

namespace App\Controller;

use App\Repository\ApplicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ApplicationController extends AbstractController
{
    #[Route('/application', name: 'app_application')]
    public function index(ApplicationRepository $applicationRepository): Response
    {
        $applications = $applicationRepository->findAll();
        return $this->render('application/index.html.twig', [
            'applications' => $applications
        ]);
    }
}
