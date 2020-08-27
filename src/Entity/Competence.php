<?php

namespace App\Entity;

use App\Entity\Niveau;
use App\Entity\GroupCompetence;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ApiResource(
 * * collectionOperations = {
 *      "get","post",
 *      "GetCompetence"={
 *      "method"="GET",
 *      "path"="/api/competences",
 *      },
 *      "PostCompetence"={
 *      "method"="POST",
 *      "path"="/competences/add",
 *      "controller"="App\Controller\CompetenceController",
 *      },
 *      "GetListGroupCompetences"={
 *      "method"="GET",
 *      "path"="/api/competences/{id}/group_competences",
 *      },
 *  },
 * itemOperations = {
 *      "get","put","delete",
 *      "get_competence"={
 *      "method"="GET",
 *      "path"="competences/{id}",
 *      },
 *      "put_competence"={
 *      "method"="PUT",
 *      "path"="competences/{id}",
 *      },
 *      "archive_competence"={
 *      "method"="PUT",
 *      "path"="/competences/{id}/archive",
 *      "controller"="App\Controller\CompetenceController",
 *      },
 *      "archive_competence"={
 *      "method"="PUT",
 *      "path"="/competences/{id}/desarchive",
 *      "controller"="App\Controller\CompetenceController::DesarchiveCompetence",
 *      },
 *  })
 * @ORM\Entity(repositoryClass=CompetenceRepository::class)
 */
class Competence
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $descriptif;

    /**
     * @ORM\OneToMany(targetEntity=Niveau::class, mappedBy="competence")
     */
    private $niveau;

    /**
     * @ORM\ManyToMany(targetEntity=GroupCompetence::class, mappedBy="competences")
     */
    private $groupCompetences;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $archive;

    /**
     * @ORM\ManyToMany(targetEntity=Referentiel::class, mappedBy="competenceVisees")
     */
    private $referentiels;

    /**
     * @ORM\OneToMany(targetEntity=CompetencesValides::class, mappedBy="competence")
     */
    private $apprenantsValides;

    

    public function __construct()
    {
        $this->niveau = new ArrayCollection();
        $this->groupCompetences = new ArrayCollection();
        $this->referentiels = new ArrayCollection();
        $this->apprenantsValides = new ArrayCollection();
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

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }

    public function setDescriptif(?string $descriptif): self
    {
        $this->descriptif = $descriptif;

        return $this;
    }

    /**
     * @return Collection|Niveau[]
     */
    public function getNiveau(): Collection
    {
        return $this->niveau;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->niveau->contains($niveau)) {
            $this->niveau[] = $niveau;
            $niveau->setCompetence($this);
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveau->contains($niveau)) {
            $this->niveau->removeElement($niveau);
            // set the owning side to null (unless already changed)
            if ($niveau->getCompetence() === $this) {
                $niveau->setCompetence(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|GroupCompetence[]
     */
    public function getGroupCompetences(): Collection
    {
        return $this->groupCompetences;
    }

    public function addGroupCompetence(GroupCompetence $groupCompetence): self
    {
        if (!$this->groupCompetences->contains($groupCompetence)) {
            $this->groupCompetences[] = $groupCompetence;
            $groupCompetence->addCompetence($this);
        }

        return $this;
    }

    public function removeGroupCompetence(GroupCompetence $groupCompetence): self
    {
        if ($this->groupCompetences->contains($groupCompetence)) {
            $this->groupCompetences->removeElement($groupCompetence);
            $groupCompetence->removeCompetence($this);
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

    /**
     * @return Collection|Referentiel[]
     */
    public function getReferentiels(): Collection
    {
        return $this->referentiels;
    }

    public function addReferentiel(Referentiel $referentiel): self
    {
        if (!$this->referentiels->contains($referentiel)) {
            $this->referentiels[] = $referentiel;
            $referentiel->addCompetenceVisee($this);
        }

        return $this;
    }

    public function removeReferentiel(Referentiel $referentiel): self
    {
        if ($this->referentiels->contains($referentiel)) {
            $this->referentiels->removeElement($referentiel);
            $referentiel->removeCompetenceVisee($this);
        }

        return $this;
    }

    /**
     * @return Collection|CompetencesValides[]
     */
    public function getApprenantsValides(): Collection
    {
        return $this->apprenantsValides;
    }

    public function addApprenantsValide(CompetencesValides $apprenantsValide): self
    {
        if (!$this->apprenantsValides->contains($apprenantsValide)) {
            $this->apprenantsValides[] = $apprenantsValide;
            $apprenantsValide->setCompetence($this);
        }

        return $this;
    }

    public function removeApprenantsValide(CompetencesValides $apprenantsValide): self
    {
        if ($this->apprenantsValides->contains($apprenantsValide)) {
            $this->apprenantsValides->removeElement($apprenantsValide);
            // set the owning side to null (unless already changed)
            if ($apprenantsValide->getCompetence() === $this) {
                $apprenantsValide->setCompetence(null);
            }
        }

        return $this;
    }

   
}
