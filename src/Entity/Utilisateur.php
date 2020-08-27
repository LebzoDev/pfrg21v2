<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Core\Annotation\ApiProperty;
use App\Controller\CreateMediaObjectAction;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 * @ApiResource(
 *     attributes={"pagination_items_per_page"=2}
 * )
 * @Vich\Uploadable
 */


class Utilisateur implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $Login;
    

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("post:apprenant")
     */
    protected $mail;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("post:apprenant")
     */
    protected $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("post:apprenant")
     */
    protected $nom;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="utilisateur")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $profil;

    
    protected $roles = [];

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    protected $photo;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $archive;

    /**
     * @ORM\OneToMany(targetEntity=GroupPromo::class, mappedBy="formateur")
     */
    private $groupPromos;

    /**
     * @ORM\OneToMany(targetEntity=Brief::class, mappedBy="formateur", orphanRemoval=true)
     */
    private $briefs;

    /**
     * @ORM\OneToMany(targetEntity=Chat::class, mappedBy="user", orphanRemoval=true)
     */
    private $chats;

    /**
     * @ORM\OneToMany(targetEntity=Commentaires::class, mappedBy="formateur", orphanRemoval=true)
     */
    private $commentaires;

    public function __construct()
    {
        $this->groupPromos = new ArrayCollection();
        $this->briefs = new ArrayCollection();
        $this->chats = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }




    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * Undocumented function
     * @see UserInterface
     * @return string|null
     */
    public function getLogin(): ?string
    {
        return $this->Login;
    }

    public function setLogin(string $Login): self
    {
        $this->Login = $Login;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->Login;
    }

    public function setUsername(string $username): self
    {
        $this->Login = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_'.$this->profil->getLibelleProfil();

        return array_unique($roles);
    }


    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Undocumented function
     * @see UserInterface
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    
    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

     /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $groupPromo->setFormateur($this);
        }

        return $this;
    }

    public function removeGroupPromo(GroupPromo $groupPromo): self
    {
        if ($this->groupPromos->contains($groupPromo)) {
            $this->groupPromos->removeElement($groupPromo);
            // set the owning side to null (unless already changed)
            if ($groupPromo->getFormateur() === $this) {
                $groupPromo->setFormateur(null);
            }
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
            $brief->setFormateur($this);
        }

        return $this;
    }

    public function removeBrief(Brief $brief): self
    {
        if ($this->briefs->contains($brief)) {
            $this->briefs->removeElement($brief);
            // set the owning side to null (unless already changed)
            if ($brief->getFormateur() === $this) {
                $brief->setFormateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Chat[]
     */
    public function getChats(): Collection
    {
        return $this->chats;
    }

    public function addChat(Chat $chat): self
    {
        if (!$this->chats->contains($chat)) {
            $this->chats[] = $chat;
            $chat->setUser($this);
        }

        return $this;
    }

    public function removeChat(Chat $chat): self
    {
        if ($this->chats->contains($chat)) {
            $this->chats->removeElement($chat);
            // set the owning side to null (unless already changed)
            if ($chat->getUser() === $this) {
                $chat->setUser(null);
            }
        }

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
            $commentaire->setFormateur($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaires $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getFormateur() === $this) {
                $commentaire->setFormateur(null);
            }
        }

        return $this;
    }


}
