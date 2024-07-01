<?php

namespace App\Entity;

use App\Repository\ServicesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServicesRepository::class)]
class Services
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
     * @var Collection<int, ServicesMedia>
     */
    #[ORM\OneToMany(targetEntity: ServicesMedia::class, mappedBy: 'services')]
    private Collection $servicesMedia;

    public function __construct()
    {
        $this->servicesMedia = new ArrayCollection();
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
     * @return Collection<int, ServicesMedia>
     */
    public function getServicesMedia(): Collection
    {
        return $this->servicesMedia;
    }

    public function addServicesMedium(ServicesMedia $servicesMedium): static
    {
        if (!$this->servicesMedia->contains($servicesMedium)) {
            $this->servicesMedia->add($servicesMedium);
            $servicesMedium->setServices($this);
        }

        return $this;
    }

    public function removeServicesMedium(ServicesMedia $servicesMedium): static
    {
        if ($this->servicesMedia->removeElement($servicesMedium)) {
            // set the owning side to null (unless already changed)
            if ($servicesMedium->getServices() === $this) {
                $servicesMedium->setServices(null);
            }
        }

        return $this;
    }
}
