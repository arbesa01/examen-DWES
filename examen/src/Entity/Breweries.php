<?php

namespace App\Entity;

use App\Repository\BreweriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BreweriesRepository::class)]
class Breweries
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $state = null;

    #[ORM\OneToMany(mappedBy: 'breweryId', targetEntity: Beers::class)]
    private Collection $beersList;

    public function __construct()
    {
        $this->beersList = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return Collection<int, Beers>
     */
    public function getBeersList(): Collection
    {
        return $this->beersList;
    }

    public function addBeersList(Beers $beersList): self
    {
        if (!$this->beersList->contains($beersList)) {
            $this->beersList->add($beersList);
            $beersList->setBreweryId($this);
        }

        return $this;
    }

    public function removeBeersList(Beers $beersList): self
    {
        if ($this->beersList->removeElement($beersList)) {
            // set the owning side to null (unless already changed)
            if ($beersList->getBreweryId() === $this) {
                $beersList->setBreweryId(null);
            }
        }

        return $this;
    }
}
