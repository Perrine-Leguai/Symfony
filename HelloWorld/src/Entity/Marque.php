<?php

namespace App\Entity;

use App\Repository\MarqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MarqueRepository::class)
 */
class Marque
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Produit::class, mappedBy="codeMarque")
     */
    private $marqueProduit;

    /**
     * @ORM\ManyToMany(targetEntity=Produit::class)
     */
    private $originProduit;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $paysdeprod;

    public function __construct()
    {
        $this->marqueProduit = new ArrayCollection();
        $this->originProduit = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getMarqueProduit(): Collection
    {
        return $this->marqueProduit;
    }

    public function addMarqueProduit(Produit $marqueProduit): self
    {
        if (!$this->marqueProduit->contains($marqueProduit)) {
            $this->marqueProduit[] = $marqueProduit;
            $marqueProduit->setCodeMarque($this);
        }

        return $this;
    }

    public function removeMarqueProduit(Produit $marqueProduit): self
    {
        if ($this->marqueProduit->removeElement($marqueProduit)) {
            // set the owning side to null (unless already changed)
            if ($marqueProduit->getCodeMarque() === $this) {
                $marqueProduit->setCodeMarque(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getOriginProduit(): Collection
    {
        return $this->originProduit;
    }

    public function addOriginProduit(Produit $originProduit): self
    {
        if (!$this->originProduit->contains($originProduit)) {
            $this->originProduit[] = $originProduit;
        }

        return $this;
    }

    public function removeOriginProduit(Produit $originProduit): self
    {
        $this->originProduit->removeElement($originProduit);

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPaysdeprod(): ?string
    {
        return $this->paysdeprod;
    }

    public function setPaysdeprod(?string $paysdeprod): self
    {
        $this->paysdeprod = $paysdeprod;

        return $this;
    }
}
