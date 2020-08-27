<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EtatBriefGroupeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=EtatBriefGroupeRepository::class)
 */
class EtatBriefGroupe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $affecte;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $rendu;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $valide;

    /**
     * @ORM\ManyToOne(targetEntity=Brief::class, inversedBy="etatBriefGroup")
     * @ORM\JoinColumn(nullable=false)
     */
    private $brief;

    /**
     * @ORM\ManyToOne(targetEntity=GroupPromo::class, inversedBy="etatBriefGroup")
     * @ORM\JoinColumn(nullable=false)
     */
    private $groupPromo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAffecte(): ?bool
    {
        return $this->affecte;
    }

    public function setAffecte(?bool $affecte): self
    {
        $this->affecte = $affecte;

        return $this;
    }

    public function getRendu(): ?bool
    {
        return $this->rendu;
    }

    public function setRendu(?bool $rendu): self
    {
        $this->rendu = $rendu;

        return $this;
    }

    public function getValide(): ?bool
    {
        return $this->valide;
    }

    public function setValide(?bool $valide): self
    {
        $this->valide = $valide;

        return $this;
    }

    public function getBrief(): ?Brief
    {
        return $this->brief;
    }

    public function setBrief(?Brief $brief): self
    {
        $this->brief = $brief;

        return $this;
    }

    public function getGroupPromo(): ?GroupPromo
    {
        return $this->groupPromo;
    }

    public function setGroupPromo(?GroupPromo $groupPromo): self
    {
        $this->groupPromo = $groupPromo;

        return $this;
    }
}
