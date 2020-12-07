<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomProduit;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $largeur;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $profondeur;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $hauteur;

    /**
     * @ORM\ManyToOne(targetEntity=Marque::class, inversedBy="marqueProduit")
     * @ORM\JoinColumn(nullable=false)
     */
    private $codeMarque;

    public function getId(): ?int
    {
        return $this->id;
    }

    

    public function getNomProduit(): ?string
    {
        return $this->nomProduit;
    }

    public function setNomProduit(?string $nomProduit): self
    {
        $this->nomProduit = $nomProduit;

        return $this;
    }
    
    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getLargeur(): ?int
    {
        return $this->largeur;
    }

    public function setLargeur(?int $largeur): self
    {
        $this->largeur = $largeur;

        return $this;
    }

    public function getProfondeur(): ?int
    {
        return $this->profondeur;
    }

    public function setProfondeur(?int $profondeur): self
    {
        $this->profondeur = $profondeur;

        return $this;
    }

    public function getHauteur(): ?int
    {
        return $this->hauteur;
    }

    public function setHauteur(?int $hauteur): self
    {
        $this->hauteur = $hauteur;

        return $this;
    }

    public function getCodeMarque(): ?Marque
    {
        return $this->codeMarque;
    }

    public function setCodeMarque(?Marque $codeMarque): self
    {
        $this->codeMarque = $codeMarque;

        return $this;
    }
}
