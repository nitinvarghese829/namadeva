<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $amount = null;

    /**
     * @var Collection<int, ProductMedia>
     */
    #[ORM\OneToMany(targetEntity: ProductMedia::class, mappedBy: 'product', cascade: ['persist'], orphanRemoval: true)]
    private Collection $productMedia;

    public function __construct()
    {
        $this->productMedia = new ArrayCollection();
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

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return Collection<int, ProductMedia>
     */
    public function getProductMedia(): Collection
    {
        return $this->productMedia;
    }

    public function addProductMedium(ProductMedia $productMedium): static
    {
        if (!$this->productMedia->contains($productMedium)) {
            $this->productMedia->add($productMedium);
            $productMedium->setProduct($this);
        }

        return $this;
    }

    public function removeProductMedium(ProductMedia $productMedium): static
    {
        if ($this->productMedia->removeElement($productMedium)) {
            // set the owning side to null (unless already changed)
            if ($productMedium->getProduct() === $this) {
                $productMedium->setProduct(null);
            }
        }

        return $this;
    }
}
