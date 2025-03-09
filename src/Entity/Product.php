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
    private ?string $whyChooseus = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    /**
     * @var Collection<int, Application>
     */
    #[ORM\ManyToMany(targetEntity: Application::class, inversedBy: 'products')]
    private Collection $productApplications;

    /**
     * @var Collection<int, ProductVariant>
     */
    #[ORM\OneToMany(targetEntity: ProductVariant::class, mappedBy: 'product', cascade: ['persist'], orphanRemoval: true)]
    private Collection $productVariants;

    /**
     * @var Collection<int, ProductKeyFeature>
     */
    #[ORM\OneToMany(targetEntity: ProductKeyFeature::class, mappedBy: 'product', cascade: ['persist'], orphanRemoval: true)]
    private Collection $productKeyFeatures;

    /**
     * @var Collection<int, ProductUseCase>
     */
    #[ORM\OneToMany(targetEntity: ProductUseCase::class, mappedBy: 'product', cascade: ['persist'], orphanRemoval: true)]
    private Collection $productUseCases;

    /**
     * @var Collection<int, FrequentlyAskedQuestion>
     */
    #[ORM\OneToMany(targetEntity: FrequentlyAskedQuestion::class, mappedBy: 'product', cascade: ['persist'], orphanRemoval: true)]
    private Collection $faqs;

    public function __construct()
    {
        $this->productMedia = new ArrayCollection();
        $this->enquiries = new ArrayCollection();
        $this->productApplications = new ArrayCollection();
        $this->productVariants = new ArrayCollection();
        $this->productKeyFeatures = new ArrayCollection();
        $this->productUseCases = new ArrayCollection();
        $this->faqs = new ArrayCollection();
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

    /**
     * @return Collection<int, Application>
     */
    public function getProductApplications(): Collection
    {
        return $this->productApplications;
    }

    public function addProductApplication(Application $productApplication): static
    {
        if (!$this->productApplications->contains($productApplication)) {
            $this->productApplications->add($productApplication);
        }

        return $this;
    }

    public function removeProductApplication(Application $productApplication): static
    {
        $this->productApplications->removeElement($productApplication);

        return $this;
    }

    /**
     * @return Collection<int, ProductVariant>
     */
    public function getProductVariants(): Collection
    {
        return $this->productVariants;
    }

    public function addProductVariant(ProductVariant $productVariant): static
    {
        if (!$this->productVariants->contains($productVariant)) {
            $this->productVariants->add($productVariant);
            $productVariant->setProduct($this);
        }

        return $this;
    }

    public function removeProductVariant(ProductVariant $productVariant): static
    {
        if ($this->productVariants->removeElement($productVariant)) {
            // set the owning side to null (unless already changed)
            if ($productVariant->getProduct() === $this) {
                $productVariant->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductKeyFeature>
     */
    public function getProductKeyFeatures(): Collection
    {
        return $this->productKeyFeatures;
    }

    public function addProductKeyFeature(ProductKeyFeature $productKeyFeature): static
    {
        if (!$this->productKeyFeatures->contains($productKeyFeature)) {
            $this->productKeyFeatures->add($productKeyFeature);
            $productKeyFeature->setProduct($this);
        }

        return $this;
    }

    public function removeProductKeyFeature(ProductKeyFeature $productKeyFeature): static
    {
        if ($this->productKeyFeatures->removeElement($productKeyFeature)) {
            // set the owning side to null (unless already changed)
            if ($productKeyFeature->getProduct() === $this) {
                $productKeyFeature->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductUseCase>
     */
    public function getProductUseCases(): Collection
    {
        return $this->productUseCases;
    }

    public function addProductUseCase(ProductUseCase $productUseCase): static
    {
        if (!$this->productUseCases->contains($productUseCase)) {
            $this->productUseCases->add($productUseCase);
            $productUseCase->setProduct($this);
        }

        return $this;
    }

    public function removeProductUseCase(ProductUseCase $productUseCase): static
    {
        if ($this->productUseCases->removeElement($productUseCase)) {
            // set the owning side to null (unless already changed)
            if ($productUseCase->getProduct() === $this) {
                $productUseCase->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FrequentlyAskedQuestion>
     */
    public function getFaqs(): Collection
    {
        return $this->faqs;
    }

    public function addFaq(FrequentlyAskedQuestion $faq): static
    {
        if (!$this->faqs->contains($faq)) {
            $this->faqs->add($faq);
            $faq->setProduct($this);
        }

        return $this;
    }

    public function removeFaq(FrequentlyAskedQuestion $faq): static
    {
        if ($this->faqs->removeElement($faq)) {
            // set the owning side to null (unless already changed)
            if ($faq->getProduct() === $this) {
                $faq->setProduct(null);
            }
        }

        return $this;
    }
}
