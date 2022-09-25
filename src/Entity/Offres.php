<?php

namespace App\Entity;

use App\Repository\OffresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OffresRepository::class)
 */
class Offres
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $contrat_type;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     */
    private $profil_desc;

    /**
     * @ORM\Column(type="text")
     */
    private $profil_comp;

    /**
     * @ORM\Column(type="text")
     */
    private $poste_desc;

    /**
     * @ORM\Column(type="text")
     */
    private $poste_mission;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $website;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity=Societe::class, inversedBy="offres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $societe;

    /**
     * @ORM\OneToMany(targetEntity=Candidat::class, mappedBy="offre", orphanRemoval=true)
     */
    private $candidat;

    public function __construct()
    {
        $this->candidat = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContratType(): ?string
    {
        return $this->contrat_type;
    }

    public function setContratType(string $contrat_type): self
    {
        $this->contrat_type = $contrat_type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getProfilDesc(): ?string
    {
        return $this->profil_desc;
    }

    public function setProfilDesc(string $profil_desc): self
    {
        $this->profil_desc = $profil_desc;

        return $this;
    }

    public function getProfilComp(): ?string
    {
        return $this->profil_comp;
    }

    public function setProfilComp(string $profil_comp): self
    {
        $this->profil_comp = $profil_comp;

        return $this;
    }

    public function getPosteDesc(): ?string
    {
        return $this->poste_desc;
    }

    public function setPosteDesc(string $poste_desc): self
    {
        $this->poste_desc = $poste_desc;

        return $this;
    }

    public function getPosteMission(): ?string
    {
        return $this->poste_mission;
    }

    public function setPosteMission(string $poste_mission): self
    {
        $this->poste_mission = $poste_mission;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getSociete(): ?Societe
    {
        return $this->societe;
    }

    public function setSociete(?Societe $societe): self
    {
        $this->societe = $societe;

        return $this;
    }

    /**
     * @return Collection<int, Candidat>
     */
    public function getCandidat(): Collection
    {
        return $this->candidat;
    }

    public function addCandidat(Candidat $candidat): self
    {
        if (!$this->candidat->contains($candidat)) {
            $this->candidat[] = $candidat;
            $candidat->setOffre($this);
        }

        return $this;
    }

    public function removeCandidat(Candidat $candidat): self
    {
        if ($this->candidat->removeElement($candidat)) {
            // set the owning side to null (unless already changed)
            if ($candidat->getOffre() === $this) {
                $candidat->setOffre(null);
            }
        }

        return $this;
    }
}
