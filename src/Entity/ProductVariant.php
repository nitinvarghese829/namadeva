<?php

namespace App\Entity;

use App\Repository\ProductVariantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


#[ORM\Entity(repositoryClass: ProductVariantRepository::class)]
#[Vich\Uploadable()]
class ProductVariant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 500)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'productVariants')]
    private ?Product $product = null;

    /**
     * @var Collection<int, ProductVariantSize>
     */
    #[ORM\OneToMany(targetEntity: ProductVariantSize::class, mappedBy: 'productVariant', cascade: ['persist'], orphanRemoval: true)]
    private Collection $variantSizes;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $originalName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

     #[Vich\UploadableField(mapping: 'productVariantMedia', fileNameProperty: 'image')]
    private $imageFile;

     /**
      * @var Collection<int, ProductVariantOptions>
      */
     #[ORM\OneToMany(targetEntity: ProductVariantOptions::class, mappedBy: 'productVariant', cascade: ['persist'], orphanRemoval: true)]
     private Collection $variantOptions;

    public function __construct()
    {
        $this->variantSizes = new ArrayCollection();
        $this->variantOptions = new ArrayCollection();
    }

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
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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

    /**
     * @return Collection<int, ProductVariantSize>
     */
    public function getVariantSizes(): Collection
    {
        return $this->variantSizes;
    }

    public function addVariantSize(ProductVariantSize $variantSize): static
    {
        if (!$this->variantSizes->contains($variantSize)) {
            $this->variantSizes->add($variantSize);
            $variantSize->setProductVariant($this);
        }

        return $this;
    }

    public function removeVariantSize(ProductVariantSize $variantSize): static
    {
        if ($this->variantSizes->removeElement($variantSize)) {
            // set the owning side to null (unless already changed)
            if ($variantSize->getProductVariant() === $this) {
                $variantSize->setProductVariant(null);
            }
        }

        return $this;
    }

    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    public function setOriginalName(?string $originalName): static
    {
        $this->originalName = $originalName;

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

    /**
     * @return Collection<int, ProductVariantOptions>
     */
    public function getVariantOptions(): Collection
    {
        return $this->variantOptions;
    }

    public function addVariantOption(ProductVariantOptions $variantOption): static
    {
        if (!$this->variantOptions->contains($variantOption)) {
            $this->variantOptions->add($variantOption);
            $variantOption->setProductVariant($this);
        }

        return $this;
    }

    public function removeVariantOption(ProductVariantOptions $variantOption): static
    {
        if ($this->variantOptions->removeElement($variantOption)) {
            // set the owning side to null (unless already changed)
            if ($variantOption->getProductVariant() === $this) {
                $variantOption->setProductVariant(null);
            }
        }

        return $this;
    }
}
