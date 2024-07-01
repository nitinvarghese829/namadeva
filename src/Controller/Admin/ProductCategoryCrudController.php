<?php

namespace App\Controller\Admin;

use App\Entity\ProductCategory;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductCategory::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Product Category')
            ->setEntityLabelInPlural('Product Categories')
            ->setSearchFields(['name']);

    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [];

        if (Crud::PAGE_INDEX === $pageName) {
            $fields = [
                IdField::new('id'),
                TextField::new('name'),
                TextField::new('slug'),
            ];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            $fields = [
                IdField::new('id'),
                TextField::new('name'),
                TextField::new('slug'),
            ];
        } elseif (Crud::PAGE_NEW === $pageName) {
            $fields = [
                TextField::new('name'),
            ];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            $fields = [
                TextField::new('name'),
                TextField::new('slug')->setFormTypeOption('disabled', 'disabled'),
            ];
        }

        return $fields;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof ProductCategory) {
            $entityInstance->setSlug($this->generateSlug($entityInstance->getName()));
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    private function generateSlug(string $name): string
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-'));
    }
}
