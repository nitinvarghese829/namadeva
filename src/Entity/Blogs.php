<?php

namespace App\Entity;

use App\Repository\BlogsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


#[ORM\Entity(repositoryClass: BlogsRepository::class)]
class Blogs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    /**
     * @var Collection<int, BlogsMedia>
     */
    #[ORM\OneToMany(targetEntity: BlogsMedia::class, mappedBy: 'blogs', cascade: ['persist'], orphanRemoval: true)]
    private Collection $blogsMedia;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column]
    #[Gedmo\Timestampable(on: "create")]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->blogsMedia = new ArrayCollection();
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

    /**
     * @return Collection<int, BlogsMedia>
     */
    public function getBlogsMedia(): Collection
    {
        return $this->blogsMedia;
    }

    public function addBlogsMedium(BlogsMedia $blogsMedium): static
    {
        if (!$this->blogsMedia->contains($blogsMedium)) {
            $this->blogsMedia->add($blogsMedium);
            $blogsMedium->setBlogs($this);
        }

        return $this;
    }

    public function removeBlogsMedium(BlogsMedia $blogsMedium): static
    {
        if ($this->blogsMedia->removeElement($blogsMedium)) {
            // set the owning side to null (unless already changed)
            if ($blogsMedium->getBlogs() === $this) {
                $blogsMedium->setBlogs(null);
            }
        }

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

}
