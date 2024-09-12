<?php

namespace App\Entity;

use App\Repository\BlogPostMediaRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: BlogPostMediaRepository::class)]
#[Vich\Uploadable()]
class BlogPostMedia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $originalName = 'aa';

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $encodedName = null;

    #[Vich\UploadableField(mapping: 'blogsMedia', fileNameProperty: 'image')]
    private $imageFile;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'blogPostMedia')]
    private ?BlogPost $blogPost = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    public function setOriginalName(?string $originalName): static
    {
        var_dump($originalName);
        $this->originalName = $originalName;

        return $this;
    }

    public function getEncodedName(): ?string
    {
        return $this->encodedName;
    }

    public function setEncodedName(?string $encodedName): static
    {

        var_dump($encodedName);
        $this->encodedName = $encodedName;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        var_dump($image);
        $this->image = $image;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param mixed $imageFile
     */
    public function setImageFile($imageFile): void
    {
        $this->imageFile = $imageFile;
    }

    public function getBlogPost(): ?BlogPost
    {
        return $this->blogPost;
    }

    public function setBlogPost(?BlogPost $blogPost): static
    {
        $this->blogPost = $blogPost;

        return $this;
    }
}
