<?php

namespace App\Entity;

use App\Repository\JeuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JeuRepository::class)]
class Jeu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $date = null;

    #[ORM\Column]
    private ?float $ventes = null;

    #[ORM\ManyToOne(inversedBy: 'jeux')]
    private ?Genre $genre = null;

    #[ORM\ManyToOne(inversedBy: 'jeux')]
    private ?Editeur $editeur = null;

    #[ORM\ManyToMany(targetEntity: Console::class, inversedBy: 'jeux')]
    private Collection $consoles;

    #[ORM\ManyToMany(targetEntity: Utilisateur::class, mappedBy: 'panier')]
    private Collection $utilisateurs;

    #[ORM\ManyToMany(targetEntity: Librairie::class, mappedBy: 'jeux')]
    private Collection $possesseurs;

    public function __construct()
    {
        $this->consoles = new ArrayCollection();
        $this->utilisateurs = new ArrayCollection();
        $this->possesseurs = new ArrayCollection();
        $this->proprietaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ?int
    {
        return $this->date;
    }

    public function setDate(int $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getVentes(): ?float
    {
        return $this->ventes;
    }

    public function setVentes(float $ventes): static
    {
        $this->ventes = $ventes;

        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getEditeur(): ?Editeur
    {
        return $this->editeur;
    }

    public function setEditeur(?Editeur $editeur): static
    {
        $this->editeur = $editeur;

        return $this;
    }

    /**
     * @return Collection<int, Console>
     */
    public function getConsoles(): Collection
    {
        return $this->consoles;
    }

    public function addConsole(Console $console): static
    {
        if (!$this->consoles->contains($console)) {
            $this->consoles->add($console);
        }

        return $this;
    }

    public function removeConsole(Console $console): static
    {
        $this->consoles->removeElement($console);

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): static
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->add($utilisateur);
            $utilisateur->addPanier($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): static
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            $utilisateur->removePanier($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Librairie>
     */
    public function getPossesseurs(): Collection
    {
        return $this->possesseurs;
    }

    public function addPossesseur(Librairie $possesseur): static
    {
        if (!$this->possesseurs->contains($possesseur)) {
            $this->possesseurs->add($possesseur);
            $possesseur->addJeux($this);
        }

        return $this;
    }

    public function removePossesseur(Librairie $possesseur): static
    {
        if ($this->possesseurs->removeElement($possesseur)) {
            $possesseur->removeJeux($this);
        }

        return $this;
    }
}
