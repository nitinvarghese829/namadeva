<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminCrudController extends AbstractCrudController
{
    public function __construct(
        public UserPasswordHasherInterface $userPasswordHasher
    ) {}

    public static function getEntityFqcn(): string
    {
        return Admin::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('roles')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('email'),
            TextField::new('password')->setFormType(PasswordType::class)->onlyOnForms(),
            ChoiceField::new('roles')->setChoices([
                'Admin' => 'ROLE_ADMIN',
                'Editor' =>'ROLE_Editor'
            ])->allowMultipleChoices()->renderExpanded(),
//            BooleanField::new('isActive')
        ];
    }

    public function createEntity($entityFqcn)
    {
        $admin = new Admin();
        $admin->setCreatedAt(new \DateTime('now'));

        return $admin;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $admin) :void
    {
        $admin->setUpdatedAt(new \DateTime('now'));

        $entityManager->persist($admin);
        $entityManager->flush();
    }

    public function createNewFormBuilder(EntityDto $admin, KeyValueStore $formOptions, AdminContext $context) :FormBuilderInterface
    {
        $formBuilder = parent::createNewFormBuilder($admin, $formOptions, $context);
        return $this->addPasswordEventListener($formBuilder);
    }


    public function createEditFormBuilder(EntityDto $admin, KeyValueStore $formOptions, AdminContext $context) :FormBuilderInterface
    {
        $formBuilder = parent::createEditFormBuilder($admin, $formOptions, $context);
        return $this->addPasswordEventListener($formBuilder);
    }

    private function addPasswordEventListener(FormBuilderInterface $formBuilder)
    {
        return $formBuilder->addEventListener(FormEvents::POST_SUBMIT, $this->hashPassword());
    }

    private function hashPassword() {
        return function($event) {
            $form = $event->getForm();
            if (!$form->isValid()) {
                return;
            }
            $password = $form->get('password')->getData();
            if ($password === null) {
                return;
            }

            $hash = $this->userPasswordHasher->hashPassword($this->getUser(), $password);
            $form->getData()->setPassword($hash);
        };
    }
}
