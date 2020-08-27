<?php

namespace App\Entity;

use App\Repository\ProfilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfilRepository::class)
 * @ApiResource(
 *  attributes={
 *      "pagination_items_per_page"=2,
 *      "security"="is_granted('ROLE_ADMIN')",
 *      "security_message"="Vous n'avez pas acces à cette ressource"
 * },
 * collectionOperations = {
 *      "get","post",
 *      "get_role_admin"={
 *      "method"="GET",
 *      "path"="/admin/profils",
 *      },
 *      "get_post_admin"={
 *      "method"="POST",
 *      "path"="/admin/profils",
 *      },
 *      "get_list_user_profil"={
 *      "method"="GET",
 *      "path"="/admin/profils/{id}/users",
 *      },
 *  },
 * itemOperations = {
 *      "get","put","patch",
 *      "get_profil_id"={
 *      "method"="GET",
 *      "path"="/admin/profils/{id}",
 *      },
 *      "put_profil_id"={
 *      "method"="PUT",
 *      "path"="/admin/profils/{id}",
 *      },
 *       "archive_ptofil"={
 *      "method"="PUT",
 *      "path"="/admin/profils/{id}/archive",
 *      "controller"="App\Controller\ProfilController",
 *      }
 *       ,
 *      "delet_profil_id"={
 *      "method"="DELETE",
 *      "path"="/admin/profils/{id}",
 *      },
 *  }
 * )
 */
class Profil
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
    private $libelle_Profil;

    /**
     * @ORM\OneToMany(targetEntity=Utilisateur::class, mappedBy="profil")
     */
    private $utilisateur;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $archive;

    public function __construct()
    {
        $this->utilisateur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleProfil(): ?string
    {
        return $this->libelle_Profil;
    }

    public function setLibelleProfil(string $libelle_Profil): self
    {
        $this->libelle_Profil = $libelle_Profil;
        return $this;
    }

    /**
     * @return Collection|Utilisateur[]
     */
    public function getUtilisateur(): Collection
    {
        return $this->utilisateur;
    }

    public function addUtilisateur(Utilisateur $utilisateur): self
    {
        if (!$this->utilisateur->contains($utilisateur)) {
            $this->utilisateur[] = $utilisateur;
            $utilisateur->setProfil($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        if ($this->utilisateur->contains($utilisateur)) {
            $this->utilisateur->removeElement($utilisateur);
            // set the owning side to null (unless already changed)
            if ($utilisateur->getProfil() === $this) {
                $utilisateur->setProfil(null);
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
