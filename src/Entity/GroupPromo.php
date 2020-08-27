<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupPromoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=GroupPromoRepository::class)
 */
class GroupPromo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="date")
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="groupPromos")
     */
    private $formateur;

    /**
     * @ORM\ManyToMany(targetEntity=Apprenant::class, inversedBy="groupPromos")
     */
    private $apprenants;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="groupPromos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $promo;

    /**
     * @ORM\OneToMany(targetEntity=EtatBriefGroupe::class, mappedBy="groupPromo", orphanRemoval=true)
     */
    private $etatBriefGroup;

    public function __construct()
    {
        $this->apprenants = new ArrayCollection();
        $this->etatBriefGroup = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getFormateur(): ?Utilisateur
    {
        return $this->formateur;
    }

    public function setFormateur(?Utilisateur $formateur): self
    {
        $this->formateur = $formateur;

        return $this;
    }

    /**
     * @return Collection|Apprenant[]
     */
    public function getApprenants(): Collection
    {
        return $this->apprenants;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenants->contains($apprenant)) {
            $this->apprenants[] = $apprenant;
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenants->contains($apprenant)) {
            $this->apprenants->removeElement($apprenant);
        }

        return $this;
    }

    public function getPromo(): ?Promo
    {
        return $this->promo;
    }

    public function setPromo(?Promo $promo): self
    {
        $this->promo = $promo;

        return $this;
    }

    /**
     * @return Collection|EtatBriefGroupe[]
     */
    public function getEtatBriefGroup(): Collection
    {
        return $this->etatBriefGroup;
    }

    public function addEtatBriefGroup(EtatBriefGroupe $etatBriefGroup): self
    {
        if (!$this->etatBriefGroup->contains($etatBriefGroup)) {
            $this->etatBriefGroup[] = $etatBriefGroup;
            $etatBriefGroup->setGroupPromo($this);
        }

        return $this;
    }

    public function removeEtatBriefGroup(EtatBriefGroupe $etatBriefGroup): self
    {
        if ($this->etatBriefGroup->contains($etatBriefGroup)) {
            $this->etatBriefGroup->removeElement($etatBriefGroup);
            // set the owning side to null (unless already changed)
            if ($etatBriefGroup->getGroupPromo() === $this) {
                $etatBriefGroup->setGroupPromo(null);
            }
        }

        return $this;
    }
}
