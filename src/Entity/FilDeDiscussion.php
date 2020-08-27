<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FilDeDiscussionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=FilDeDiscussionRepository::class)
 */
class FilDeDiscussion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=ApprenantLivrablePartiel::class, inversedBy="filDeDiscussion", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $apprenantLivrablePartiel;

    /**
     * @ORM\OneToMany(targetEntity=Commentaires::class, mappedBy="filDeDiscussion", orphanRemoval=true)
     */
    private $commentaires;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApprenantLivrablePartiel(): ?ApprenantLivrablePartiel
    {
        return $this->apprenantLivrablePartiel;
    }

    public function setApprenantLivrablePartiel(ApprenantLivrablePartiel $apprenantLivrablePartiel): self
    {
        $this->apprenantLivrablePartiel = $apprenantLivrablePartiel;

        return $this;
    }

    /**
     * @return Collection|Commentaires[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaires $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setFilDeDiscussion($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaires $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getFilDeDiscussion() === $this) {
                $commentaire->setFilDeDiscussion(null);
            }
        }

        return $this;
    }
}
