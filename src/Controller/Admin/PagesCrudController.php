<?php

namespace App\Controller\Admin;

use App\Entity\Pages;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PagesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Pages::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextField::new('title'),
            TextField::new('keyword'),
            TextField::new('description'),
        ];
    }

}
