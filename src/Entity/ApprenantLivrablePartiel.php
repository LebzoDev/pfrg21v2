<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ApprenantLivrablePartielRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ApprenantLivrablePartielRepository::class)
 */
class ApprenantLivrablePartiel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateSoumission;

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
    private $enRetard;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $aRefaire;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $valide;

    /**
     * @ORM\ManyToOne(targetEntity=Apprenant::class, inversedBy="livrablesPartiels")
     * @ORM\JoinColumn(nullable=false)
     */
    private $apprenant;

    /**
     * @ORM\ManyToOne(targetEntity=LivrablePartiel::class, inversedBy="apprenants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $livrablePartiel;

    /**
     * @ORM\OneToOne(targetEntity=FilDeDiscussion::class, mappedBy="apprenantLivrablePartiel", cascade={"persist", "remove"})
     */
    private $filDeDiscussion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateSoumission(): ?\DateTimeInterface
    {
        return $this->dateSoumission;
    }

    public function setDateSoumission(?\DateTimeInterface $dateSoumission): self
    {
        $this->dateSoumission = $dateSoumission;

        return $this;
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

    public function getEnRetard(): ?bool
    {
        return $this->enRetard;
    }

    public function setEnRetard(?bool $enRetard): self
    {
        $this->enRetard = $enRetard;

        return $this;
    }

    public function getARefaire(): ?bool
    {
        return $this->aRefaire;
    }

    public function setARefaire(?bool $aRefaire): self
    {
        $this->aRefaire = $aRefaire;

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

    public function getApprenant(): ?Apprenant
    {
        return $this->apprenant;
    }

    public function setApprenant(?Apprenant $apprenant): self
    {
        $this->apprenant = $apprenant;

        return $this;
    }

    public function getLivrablePartiel(): ?LivrablePartiel
    {
        return $this->livrablePartiel;
    }

    public function setLivrablePartiel(?LivrablePartiel $livrablePartiel): self
    {
        $this->livrablePartiel = $livrablePartiel;

        return $this;
    }

    public function getFilDeDiscussion(): ?FilDeDiscussion
    {
        return $this->filDeDiscussion;
    }

    public function setFilDeDiscussion(FilDeDiscussion $filDeDiscussion): self
    {
        $this->filDeDiscussion = $filDeDiscussion;

        // set the owning side of the relation if necessary
        if ($filDeDiscussion->getApprenantLivrablePartiel() !== $this) {
            $filDeDiscussion->setApprenantLivrablePartiel($this);
        }

        return $this;
    }
}
