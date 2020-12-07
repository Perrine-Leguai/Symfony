<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\Length(max=255, maxMessage= "Nom de produit trop long. - de 255 caractères")
     */
    private $nomProduit;

    /**
     * @ORM\Column(type="integer")
     * @Assert\positive
     */
    private $prix;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\positive
     */
    private $largeur;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\positive
     */
    private $profondeur;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\positive
     */
    private $hauteur;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\positive
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

    public function setPrix(?int $prix): self
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

    public function getCodeMarque(): ?int 
    {
        return $this->codeMarque;
    }

    public function setCodeMarque(?int $codeMarque): self
    {
        $this->codeMarque = $codeMarque;

        return $this;
    }
}
