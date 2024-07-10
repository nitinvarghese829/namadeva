<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Entity\Application;
use App\Entity\Blogs;
use App\Entity\Enquiry;
use App\Entity\Pages;
use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Entity\Services;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class DashboardController extends AbstractDashboardController
{

    private $connection;
    private $em;
    public function __construct(Connection $connection, EntityManagerInterface $em)
    {
        $this->connection = $connection;
        $this->em = $em;
    }
    #[Route('/dashboard', name: 'dashboard')]
    public function index(): Response
    {
        $sql = "SELECT count(*) FROM product";
        $count['product'] = $this->connection->fetchOne($sql);
        $sql = "SELECT count(*) FROM services";
        $count['services'] = $this->connection->fetchOne($sql);

        return $this->render('admin/dashboard.html.twig', ['count' => $count]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Namadeva');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            MenuItem::subMenu('Users', 'fa fa-tags')->setSubItems([
                MenuItem::linkToCrud('Admin', 'fa fa-user-tie', Admin::class),
            ]),
            MenuItem::subMenu('Product', 'fa fa-tags')->setSubItems([
                MenuItem::linkToCrud('Product', 'fa-cart-shopping', Product::class),
                MenuItem::linkToCrud('Category', 'fa-cart-shopping', ProductCategory::class),
            ]),
            MenuItem::subMenu('Service', 'fa fa-tags')->setSubItems([
                MenuItem::linkToCrud('Services', 'fa-cart-shopping', Services::class),
            ]),
            MenuItem::linkToCrud('Application', 'fa-cart-shopping', Application::class),
            MenuItem::subMenu('Knowledge Hub', 'fa fa-tags')->setSubItems([
                MenuItem::linkToCrud('Blogs', 'fa-blogs', Blogs::class),
            ]),
            MenuItem::linkToCrud('Enquiry', 'fa-cart-shopping', Enquiry::class),
            MenuItem::linkToCrud('Pages', 'fa-cart-shopping', Pages::class),
            MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),

        ];
    }
}
