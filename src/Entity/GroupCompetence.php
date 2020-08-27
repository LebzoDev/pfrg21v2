<?php

namespace App\Entity;

use App\Entity\Competence;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\CompetenceController;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupCompetenceRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ApiResource(
 * itemOperations = {
 *      "get","put","delete",
 *      "get_competence"={
 *      "method"="GET",
 *      "path"="group_competences/{id}",
 *      },
 *      "put_competence"={
 *      "method"="PUT",
 *      "path"="group_competences/{id}",
 *      },
 *      "archive_group_competence"={
 *      "method"="PUT",
 *      "path"="/group_competences/{id}/archive",
 *      "controller"="App\Controller\CompetenceController::ArchiveGroupCompetence",
 *      },
 *      "desarchive_group_competence"={
 *      "method"="PUT",
 *      "path"="/group_competences/{id}/desarchive",
 *      "controller"="App\Controller\CompetenceController::DesarchiveGroupCompetence",
 *      }
 * })
 * @ORM\Entity(repositoryClass=GroupCompetenceRepository::class)
 */
class GroupCompetence
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
     * @ORM\ManyToMany(targetEntity=Competence::class, inversedBy="groupCompetences")
     */
    private $competences;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archive;

    public function __construct()
    {
        $this->competences = new ArrayCollection();
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
     * @return Collection|Competence[]
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(Competence $competence): self
    {
        if (!$this->competences->contains($competence)) {
            $this->competences[] = $competence;
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        if ($this->competences->contains($competence)) {
            $this->competences->removeElement($competence);
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
