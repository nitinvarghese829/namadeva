<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Entity\Product;
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
            ]),
            MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),

        ];
    }
}
