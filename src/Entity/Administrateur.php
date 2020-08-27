<?php

namespace App\Entity;

use App\Repository\AdministrateurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdministrateurRepository::class)
 */
class Administrateur
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
    private $matricule_Admin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatriculeAdmin(): ?string
    {
        return $this->matricule_Admin;
    }

    public function setMatriculeAdmin(string $matricule_Admin): self
    {
        $this->matricule_Admin = $matricule_Admin;

        return $this;
    }
}
