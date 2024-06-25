<?php

namespace App\Entity;

use App\Repository\ProductMediaRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ProductMediaRepository::class)]
#[Vich\Uploadable()]
class ProductMedia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $originalName = null;

    #[ORM\Column(length: 255)]
    private ?string $encodedName = null;

    #[Vich\UploadableField(mapping: 'productMedia', fileNameProperty: 'image')]
    private $imageFile;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'productMedia')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;


    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImageFile($imageFile): void
    {
        $this->imageFile = $imageFile;
    }

    public function getDir() {
        return "uploads/";
    }

    public function getWebPath(){
        return "{$this->getDir()}{$this->image}";
    }

    public function __toString()
    {
        return $this->image;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    public function setOriginalName(string $originalName): static
    {
        $this->originalName = $originalName;

        return $this;
    }

    public function getEncodedName(): ?string
    {
        return $this->encodedName;
    }

    public function setEncodedName(string $encodedName): static
    {
        $this->encodedName = $encodedName;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }
}
