<?php

namespace App\Controller\Admin;

use App\Entity\Blogs;
use App\Form\BlogPostFormType;
use App\Form\BlogsImageType;
use App\Form\ProductImageType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class BlogsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Blogs::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextEditorField::new('description', 'Content')
                ->setFormType(CKEditorType::class)
                ->setFormTypeOptions([
                'config' => [
                    'toolbar' => [
                        ['name' => 'basicstyles', 'items' => ['Bold', 'Italic', 'Underline']],
                        ['name' => 'paragraph', 'items' => ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent']],
                        ['name' => 'insert', 'items' => ['Table', 'HorizontalRule']],
                    ],
                    'extraPlugins' => 'table',
                ],
            ]),
            AssociationField::new('blogPosts'),
            TextField::new('tags')->onlyOnForms(),
            TextField::new('author')->onlyOnForms(),
            CollectionField::new('blogsMedia')->setEntryType(BlogsImageType::class)
                ->setFormTypeOptions(['by_reference' => false])
                ->onlyOnForms(),
            TextField::new('title')->onlyOnForms(),
            TextField::new('keywords')->onlyOnForms(),
            TextField::new('metaDescription')->onlyOnForms(),
        ];
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        foreach ($entityInstance->getBlogPosts() as $blogPost) {
            $blogPost->setBlogs($entityInstance);
            $entityManager->persist($blogPost);
            $entityManager->flush();
        }
        $this->attachFiles($entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Blogs) {
            $entityInstance->setSlug($this->generateSlug($entityInstance->getName()));
            $entityInstance->setCreatedAt(date_create_immutable('now'));
        }

        foreach ($entityInstance->getBlogPosts() as $blogPost) {
            $blogPost->setBlogs($entityInstance);
            $entityManager->persist($blogPost);
            $entityManager->flush();
        }
        $this->attachFiles($entityInstance);
        parent::persistEntity($entityManager, $entityInstance);
    }

    private function attachFiles($object){
        foreach($object->getBlogsMedia() as $image) {
            if($image->getImageFile() instanceof UploadedFile){
                $image->setOriginalName($image->getImageFile()->getClientOriginalName());
                $image->setEncodedName($image->getImageFile()->getClientOriginalName());
                $image->setImage($image->getImageFile()->getClientOriginalName());
            }
        }
    }

    private function generateSlug(string $name): string
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-'));
    }

}
