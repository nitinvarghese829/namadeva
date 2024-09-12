<?php

namespace App\Entity;

use App\Repository\BlogPostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: BlogPostRepository::class)]
#[Vich\Uploadable()]
class BlogPost
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'blogPosts')]
    private ?Blogs $blogs = null;

    /**
     * @var Collection<int, BlogPostMedia>
     */
    #[ORM\OneToMany(targetEntity: BlogPostMedia::class, mappedBy: 'blogPost', cascade: ['persist'], orphanRemoval: true)]
    private Collection $blogPostMedia;

    public function __construct()
    {
        $this->blogPostMedia = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->description;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBlogs(): ?Blogs
    {
        return $this->blogs;
    }

    public function setBlogs(?Blogs $blogs): static
    {
        $this->blogs = $blogs;

        return $this;
    }

    /**
     * @return Collection<int, BlogPostMedia>
     */
    public function getBlogPostMedia(): Collection
    {
        return $this->blogPostMedia;
    }

    public function addBlogPostMedium(BlogPostMedia $blogPostMedium): static
    {
        if (!$this->blogPostMedia->contains($blogPostMedium)) {
            $this->blogPostMedia->add($blogPostMedium);
            $blogPostMedium->setBlogPost($this);
        }

        return $this;
    }

    public function removeBlogPostMedium(BlogPostMedia $blogPostMedium): static
    {
        if ($this->blogPostMedia->removeElement($blogPostMedium)) {
            // set the owning side to null (unless already changed)
            if ($blogPostMedium->getBlogPost() === $this) {
                $blogPostMedium->setBlogPost(null);
            }
        }

        return $this;
    }


}
