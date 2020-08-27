<?php

namespace App\Entity;

use App\Entity\Promo;
use App\Entity\GroupCompetence;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReferentielRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ApiResource(
 *  collectionOperations = {
 *      "get","post",
 *      "list_referentiels"={
 *      "method"="GET",
 *      "path"="admin/referentiels",
 *      },
 *      "list_competences_referentiel"={
 *      "method"="GET",
 *      "path"="admin/referentiels/id/competences",
 *      },
 *      "referentiel_addCompetences"={
 *      "method"="POST",
 *      "path"="admin/referentiel/{id}/addCompetence"
 *      },
 *      "referentiel_removeCompetences"={
 *      "method"="POST",
 *      "path"="admin/referentiel/{id}/removeCompetence"
 *      },
 *  },
 *  itemOperations = {
 *      "get","put",
 *      "PutReferentielArchive"={
 *      "methods"="PUT",
 *      "path"="admin/referentiel/{id}/archive"
 *      },
 *      "PutReferentielDesarchive"={
 *      "methods"="PUT",
 *      "path"="admin/referentiel/{id}/desarchive"
 *      },
 *  })
 * @ORM\Entity(repositoryClass=ReferentielRepository::class)
 */
class Referentiel
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
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $presentation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $programme;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $critereDev;

    /**
     * @ORM\ManyToMany(targetEntity=GroupCompetence::class, inversedBy="referentiels")
     */
    private $competenceVisees;

    /**
     * @ORM\OneToMany(targetEntity=Promo::class, mappedBy="referentiel")
     */
    private $promos;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archive;

    public function __construct()
    {
        $this->competenceVisees = new ArrayCollection();
        $this->promos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getProgramme(): ?string
    {
        return $this->programme;
    }

    public function setProgramme(?string $programme): self
    {
        $this->programme = $programme;

        return $this;
    }

    public function getCritereDev(): ?string
    {
        return $this->critereDev;
    }

    public function setCritereDev(?string $critereDev): self
    {
        $this->critereDev = $critereDev;

        return $this;
    }

    /**
     * @return Collection|GroupCompetence[]
     */
    public function getCompetenceVisees(): Collection
    {
        return $this->competenceVisees;
    }

    public function addCompetenceVisee(GroupCompetence $competenceVisee): self
    {
        if (!$this->competenceVisees->contains($competenceVisee)) {
            $this->competenceVisees[] = $competenceVisee;
        }

        return $this;
    }

    public function removeCompetenceVisee(GroupCompetence $competenceVisee): self
    {
        if ($this->competenceVisees->contains($competenceVisee)) {
            $this->competenceVisees->removeElement($competenceVisee);
        }

        return $this;
    }

    /**
     * @return Collection|Promo[]
     */
    public function getPromos(): Collection
    {
        return $this->promos;
    }

    public function addPromo(Promo $promo): self
    {
        if (!$this->promos->contains($promo)) {
            $this->promos[] = $promo;
            $promo->setReferentiel($this);
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promos->contains($promo)) {
            $this->promos->removeElement($promo);
            // set the owning side to null (unless already changed)
            if ($promo->getReferentiel() === $this) {
                $promo->setReferentiel(null);
            }
        }

        return $this;
    }

    public function getArchive(): ?bool
    {
        return $this->archive;
    }

    public function setArchive(bool $archive): self
    {
        $this->archive = $archive;

        return $this;
    }
}
