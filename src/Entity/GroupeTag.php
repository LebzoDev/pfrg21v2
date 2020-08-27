<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GroupeTagRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=GroupeTagRepository::class)
  *  @UniqueEntity(
 * fields={"libelleGroupTag"},
 * message="Le libelleGroupTag doit être unique"
 * )
 * * @ApiResource(
 * attributes={
 *      "security"="is_granted('ROLE_ADMIN')",
 *      "security_message"="Vous n'avez pas acces à cette ressource"
 * },
 * collectionOperations = {
 *      "get","post",
 *      "get_role_admin"={
 *      "method"="GET",
 *      "path"="/admin/groupe_tags",
 *      },
 *      "GroupeTag_add"={
 *      "method"="post",
 *      "path"="/admin/groupe_tags/add",
 *      "controller"="App\Controller\GroupeTagController::index",
 *      },
 * "GroupeTag_remove_tag"={
 *      "method"="post",
 *      "path"="api/admin/groupe_tags/{id}/removeTag",
 *      "controller"="App\Controller\GroupeTagController::removeTadd",
 *      },
 * * "GroupeTag_add_tag"={
 *      "method"="post",
 *      "path"="api/admin/groupe_tags/{id}/addTag",
 *      "controller"="App\Controller\GroupeTagController::addTag",
 *      },
 *  },
 * itemOperations = {
 *  "get","put","delete",
 * "get_groupe_tag_id"={
 *      "method"="GET",
 *      "path"="/admin/groupe_tags/{id}",
 *      },
 *    "put_groupe_tag_id"={
 *      "method"="PUT",
 *      "path"="/admin/groupe_tags/{id}",
 *      },
 *  "delet_groupe_tag_id"={
 *      "method"="DELETE",
 *      "path"="/admin/groupe_tags/{id}",
 *      },
 * }
 * )
 */
class GroupeTag
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $libelleGroupTag;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="groupeTags")
     */
    private $Tags;

    public function __construct()
    {
        $this->Tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleGroupTag(): ?string
    {
        return $this->libelleGroupTag;
    }

    public function setLibelleGroupTag(string $libelleGroupTag): self
    {
        $this->libelleGroupTag = $libelleGroupTag;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->Tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->Tags->contains($tag)) {
            $this->Tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->Tags->contains($tag)) {
            $this->Tags->removeElement($tag);
        }

        return $this;
    }
}
