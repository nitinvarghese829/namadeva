<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $amount = null;

    /**
     * @var Collection<int, ProductMedia>
     */
    #[ORM\OneToMany(targetEntity: ProductMedia::class, mappedBy: 'product', cascade: ['persist'], orphanRemoval: true)]
    private Collection $productMedia;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?ProductCategory $category = null;

    #[ORM\Column]
    private ?bool $isTrending = false;

    /**
     * @var Collection<int, Enquiry>
     */
    #[ORM\OneToMany(targetEntity: Enquiry::class, mappedBy: 'product')]
    private Collection $enquiries;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $keyFeatures = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $applications = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $whyChooseus = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    public function __construct()
    {
        $this->productMedia = new ArrayCollection();
        $this->enquiries = new ArrayCollection();
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

    public function getCategory(): ?ProductCategory
    {
        return $this->category;
    }

    public function setCategory(?ProductCategory $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function isTrending(): ?bool
    {
        return $this->isTrending;
    }

    public function setIsTrending(bool $isTrending): static
    {
        $this->isTrending = $isTrending;

        return $this;
    }

    /**
     * @return Collection<int, Enquiry>
     */
    public function getEnquiries(): Collection
    {
        return $this->enquiries;
    }

    public function addEnquiry(Enquiry $enquiry): static
    {
        if (!$this->enquiries->contains($enquiry)) {
            $this->enquiries->add($enquiry);
            $enquiry->setProduct($this);
        }

        return $this;
    }

    public function removeEnquiry(Enquiry $enquiry): static
    {
        if ($this->enquiries->removeElement($enquiry)) {
            // set the owning side to null (unless already changed)
            if ($enquiry->getProduct() === $this) {
                $enquiry->setProduct(null);
            }
        }

        return $this;
    }

    public function getKeyFeatures(): ?string
    {
        return $this->keyFeatures;
    }

    public function setKeyFeatures(string $keyFeatures): static
    {
        $this->keyFeatures = $keyFeatures;

        return $this;
    }

    public function getApplications(): ?string
    {
        return $this->applications;
    }

    public function setApplications(string $applications): static
    {
        $this->applications = $applications;

        return $this;
    }

    public function getWhyChooseus(): ?string
    {
        return $this->whyChooseus;
    }

    public function setWhyChooseus(string $whyChooseus): static
    {
        $this->whyChooseus = $whyChooseus;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
