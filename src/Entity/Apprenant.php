<?php

namespace App\Entity;

use App\Entity\GroupPromo;
use App\Entity\Utilisateur;
use App\Entity\ProfilSortie;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ApprenantRepository;
use App\Entity\ApprenantLivrablePartiel;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use App\Controller\CompetencesAcquisesController;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *   collectionOperations = {
 *      "get","post",
 *      "competences_acquises"={
 *      "method"="GET",
 *      "path"="formateurs/promo/{id}/referentiel/{referentielId}/competences",
 *      "controller"="App\Controller\CompetencesAcquisesController::index",
 *      },
 *       "competences_acquises_apprenant"={
 *      "method"="GET",
 *      "path"="apprenant/{apprenantId}/promo/{id}/referentiel/{referentielId}/competences",
 *      "controller"="App\Controller\CompetencesAcquisesController::index1",
 *      }
 *   },
 *      itemOperations={
 *      "get","put","patch",
 *      "reglages"={
 *      "method"="PUT",
 *      "path"="/reglages",
 *      "controller"="App\Controller\ReglagesController",
 *      }
 * })
 * @ORM\Entity(repositoryClass=ApprenantRepository::class)
 */
class Apprenant extends Utilisateur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("post:apprenant")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("post:apprenant")
     */
    private $status;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("post:apprenant")
     */
    private $profilId;

    /**
     * @ORM\ManyToOne(targetEntity=ProfilSortie::class, inversedBy="apprenants")
     * @Groups("post:apprenant")
     */
    private $profilSortie;

    /**
     * @ORM\ManyToMany(targetEntity=GroupPromo::class, mappedBy="apprenants")
     */
    private $groupPromos;

    /**
     * @ORM\OneToMany(targetEntity=ApprenantLivrablePartiel::class, mappedBy="apprenant")
     */
    private $livrablesPartiels;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="apprenants")
     * @Groups("post:apprenant")
     */
    private $promo;

    /**
     * @ORM\OneToMany(targetEntity=CompetencesValides::class, mappedBy="apprenant")
     * @Groups("post:apprenant")
     */
    private $competencesValides;

    /**
     * @ORM\OneToMany(targetEntity=BriefApprenant::class, mappedBy="apprenant", orphanRemoval=true)
     */
    private $briefApprenants;

    /**
     * @ORM\OneToMany(targetEntity=LivrableAttenduApprenant::class, mappedBy="apprenant", orphanRemoval=true)
     */
    private $livrableAttenduApprenants;

    public function __construct()
    {
        parent::__construct();
        $this->groupPromos = new ArrayCollection();
        $this->livrablesPartiels = new ArrayCollection();
        $this->competencesValides = new ArrayCollection();
        $this->briefApprenants = new ArrayCollection();
        $this->livrableAttenduApprenants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMyId(): ?int
    {
        return $this->id;
    }


    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getProfilSortie(): ?ProfilSortie
    {
        return $this->profilSortie;
    }

    public function setProfilSortie(?ProfilSortie $profilSortie): self
    {
        $this->profilSortie = $profilSortie;

        return $this;
    }

    /**
     * @return Collection|GroupPromo[]
     */
    public function getGroupPromos(): Collection
    {
        return $this->groupPromos;
    }

    public function addGroupPromo(GroupPromo $groupPromo): self
    {
        if (!$this->groupPromos->contains($groupPromo)) {
            $this->groupPromos[] = $groupPromo;
            $groupPromo->addApprenant($this);
        }

        return $this;
    }

    public function removeGroupPromo(GroupPromo $groupPromo): self
    {
        if ($this->groupPromos->contains($groupPromo)) {
            $this->groupPromos->removeElement($groupPromo);
            $groupPromo->removeApprenant($this);
        }

        return $this;
    }

    /**
     * @return Collection|ApprenantLivrablePartiel[]
     */
    public function getLivrablesPartiels(): Collection
    {
        return $this->livrablesPartiels;
    }

    public function addLivrablesPartiel(ApprenantLivrablePartiel $livrablesPartiel): self
    {
        if (!$this->livrablesPartiels->contains($livrablesPartiel)) {
            $this->livrablesPartiels[] = $livrablesPartiel;
            $livrablesPartiel->setApprenant($this);
        }

        return $this;
    }

    public function removeLivrablesPartiel(ApprenantLivrablePartiel $livrablesPartiel): self
    {
        if ($this->livrablesPartiels->contains($livrablesPartiel)) {
            $this->livrablesPartiels->removeElement($livrablesPartiel);
            // set the owning side to null (unless already changed)
            if ($livrablesPartiel->getApprenant() === $this) {
                $livrablesPartiel->setApprenant(null);
            }
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
     * @return Collection|CompetencesValides[]
     */
    public function getCompetencesValides(): Collection
    {
        return $this->competencesValides;
    }

    public function addCompetencesValide(CompetencesValides $competencesValide): self
    {
        if (!$this->competencesValides->contains($competencesValide)) {
            $this->competencesValides[] = $competencesValide;
            $competencesValide->setApprenant($this);
        }

        return $this;
    }

    public function removeCompetencesValide(CompetencesValides $competencesValide): self
    {
        if ($this->competencesValides->contains($competencesValide)) {
            $this->competencesValides->removeElement($competencesValide);
            // set the owning side to null (unless already changed)
            if ($competencesValide->getApprenant() === $this) {
                $competencesValide->setApprenant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BriefApprenant[]
     */
    public function getBriefApprenants(): Collection
    {
        return $this->briefApprenants;
    }

    public function addBriefApprenant(BriefApprenant $briefApprenant): self
    {
        if (!$this->briefApprenants->contains($briefApprenant)) {
            $this->briefApprenants[] = $briefApprenant;
            $briefApprenant->setApprenant($this);
        }

        return $this;
    }

    public function removeBriefApprenant(BriefApprenant $briefApprenant): self
    {
        if ($this->briefApprenants->contains($briefApprenant)) {
            $this->briefApprenants->removeElement($briefApprenant);
            // set the owning side to null (unless already changed)
            if ($briefApprenant->getApprenant() === $this) {
                $briefApprenant->setApprenant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|LivrableAttenduApprenant[]
     */
    public function getLivrableAttenduApprenants(): Collection
    {
        return $this->livrableAttenduApprenants;
    }

    public function addLivrableAttenduApprenant(LivrableAttenduApprenant $livrableAttenduApprenant): self
    {
        if (!$this->livrableAttenduApprenants->contains($livrableAttenduApprenant)) {
            $this->livrableAttenduApprenants[] = $livrableAttenduApprenant;
            $livrableAttenduApprenant->setApprenant($this);
        }

        return $this;
    }

    public function removeLivrableAttenduApprenant(LivrableAttenduApprenant $livrableAttenduApprenant): self
    {
        if ($this->livrableAttenduApprenants->contains($livrableAttenduApprenant)) {
            $this->livrableAttenduApprenants->removeElement($livrableAttenduApprenant);
            // set the owning side to null (unless already changed)
            if ($livrableAttenduApprenant->getApprenant() === $this) {
                $livrableAttenduApprenant->setApprenant(null);
            }
        }

        return $this;
    }
}
