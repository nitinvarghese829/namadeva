<?php

namespace App\Controller\Admin;

use App\Entity\Enquiry;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EnquiryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Enquiry::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('firstname'),
            TextField::new('lastname'),
            TextField::new('phone'),
            TextField::new('email'),
            TextField::new('pincode'),
            AssociationField::new('product'),

        ];
    }

}
