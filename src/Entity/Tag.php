<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Controller\TagController;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 *  @UniqueEntity(
 * fields={"libelleTag"},
 * message="Le Libelle doit être unique"
 * )
 * @ApiResource(
 * attributes={
 *      "security"="is_granted('ROLE_ADMIN')",
 *      "security_message"="Vous n'avez pas acces à cette ressource"
 * },
 * collectionOperations = {
 *      "get","post",
 *      "get_role_admin"={
 *      "method"="GET",
 *      "path"="/admin/tags",
 *      },
 *      "api_tags_PostTag_collection"={
 *      "method"="POST",
 *      "path"="/admin/tags/add",
 *      "controller"="App\Controller\TagController::index",
 *      },
 *  },
 * itemOperations = {
 *  "get","put","delete",
 * "get_tag_id"={
 *      "method"="GET",
 *      "path"="/admin/tags/{id}",
 *      },
 *    "put_tag_id"={
 *      "method"="PUT",
 *      "path"="/admin/tags/{id}",
 *      },
 *  "delet_tag_id"={
 *      "method"="DELETE",
 *      "path"="/admin/tags/{id}",
 *      },
 * }
 * )
 */
class Tag
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
    private $libelleTag;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeTag::class, mappedBy="Tags")
     */
    private $groupeTags;

    /**
     * @ORM\ManyToMany(targetEntity=Brief::class, mappedBy="tags")
     */
    private $briefs;

    public function __construct()
    {
        $this->groupeTags = new ArrayCollection();
        $this->briefs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleTag(): ?string
    {
        return $this->libelleTag;
    }

    public function setLibelleTag(string $libelleTag): self
    {
        $this->libelleTag = $libelleTag;

        return $this;
    }

    /**
     * @return Collection|GroupeTag[]
     */
    public function getGroupeTags(): Collection
    {
        return $this->groupeTags;
    }

    public function addGroupeTag(GroupeTag $groupeTag): self
    {
        if (!$this->groupeTags->contains($groupeTag)) {
            $this->groupeTags[] = $groupeTag;
            $groupeTag->addTag($this);
        }

        return $this;
    }

    public function removeGroupeTag(GroupeTag $groupeTag): self
    {
        if ($this->groupeTags->contains($groupeTag)) {
            $this->groupeTags->removeElement($groupeTag);
            $groupeTag->removeTag($this);
        }

        return $this;
    }

    /**
     * @return Collection|Brief[]
     */
    public function getBriefs(): Collection
    {
        return $this->briefs;
    }

    public function addBrief(Brief $brief): self
    {
        if (!$this->briefs->contains($brief)) {
            $this->briefs[] = $brief;
            $brief->addTag($this);
        }

        return $this;
    }

    public function removeBrief(Brief $brief): self
    {
        if ($this->briefs->contains($brief)) {
            $this->briefs->removeElement($brief);
            $brief->removeTag($this);
        }

        return $this;
    }
}
