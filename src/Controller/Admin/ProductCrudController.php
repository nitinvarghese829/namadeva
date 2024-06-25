<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductImageType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextEditorField::new('description')->onlyOnForms(),
            MoneyField::new('amount')->setCurrency('INR'),
            CollectionField::new('productMedia')->setEntryType(ProductImageType::class)
                ->setFormTypeOptions(['by_reference' => false])
                ->onlyOnForms(),

        ];
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->attachFiles($entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->attachFiles($entityInstance);
        parent::persistEntity($entityManager, $entityInstance);
    }

    private function attachFiles($object){
        foreach($object->getProductMedia() as $image) {
            if($image->getImageFile() instanceof UploadedFile){
                $image->setOriginalName($image->getImageFile()->getClientOriginalName());
                $image->setEncodedName($image->getImageFile()->getClientOriginalName());
                $image->setImage($image->getImageFile()->getClientOriginalName());
            }
        }
    }
}
