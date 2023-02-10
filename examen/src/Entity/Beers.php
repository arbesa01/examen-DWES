<?php

namespace App\Entity;

use App\Repository\BeersRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BeersRepository::class)]
class Beers
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $abv = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 1, nullable: true)]
    private ?string $ibu = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $style = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 1)]
    private ?string $ounces = null;

    #[ORM\ManyToOne(inversedBy: 'beersList')]
    #[ORM\JoinColumn(nullable: false, name: 'brewery_id', referencedColumnName: 'id')]
    private ?Breweries $breweryId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getAbv(): ?float
    {
        return $this->abv;
    }

    public function setAbv(?float $abv): self
    {
        $this->abv = $abv;

        return $this;
    }

    public function getIbu(): ?string
    {
        return $this->ibu;
    }

    public function setIbu(?string $ibu): self
    {
        $this->ibu = $ibu;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(?string $style): self
    {
        $this->style = $style;

        return $this;
    }

    public function getOunces(): ?string
    {
        return $this->ounces;
    }

    public function setOunces(string $ounces): self
    {
        $this->ounces = $ounces;

        return $this;
    }

    public function getBreweryId(): ?Breweries
    {
        return $this->breweryId;
    }

    public function setBreweryId(?Breweries $breweryId): self
    {
        $this->breweryId = $breweryId;

        return $this;
    }
}
