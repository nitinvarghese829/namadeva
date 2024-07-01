<?php

namespace App\Controller\Admin;

use App\Entity\Enquiry;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EnquiryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Enquiry::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
