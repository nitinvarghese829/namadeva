<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
class Application
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, ApplicationMedia>
     */
    #[ORM\OneToMany(targetEntity: ApplicationMedia::class, mappedBy: 'application', cascade: ['persist'], orphanRemoval: true)]
    private Collection $applicationMedia;

    public function __construct()
    {
        $this->applicationMedia = new ArrayCollection();
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

    /**
     * @return Collection<int, ApplicationMedia>
     */
    public function getApplicationMedia(): Collection
    {
        return $this->applicationMedia;
    }

    public function addApplicationMedium(ApplicationMedia $applicationMedium): static
    {
        if (!$this->applicationMedia->contains($applicationMedium)) {
            $this->applicationMedia->add($applicationMedium);
            $applicationMedium->setApplication($this);
        }

        return $this;
    }

    public function removeApplicationMedium(ApplicationMedia $applicationMedium): static
    {
        if ($this->applicationMedia->removeElement($applicationMedium)) {
            // set the owning side to null (unless already changed)
            if ($applicationMedium->getApplication() === $this) {
                $applicationMedium->setApplication(null);
            }
        }

        return $this;
    }
}
