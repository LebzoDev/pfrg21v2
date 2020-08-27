<?php

namespace App\Entity;

use App\Repository\FormateurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormateurRepository::class)
 */
class Formateur
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
    private $matricule_Formateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatriculeFormateur(): ?string
    {
        return $this->matricule_Formateur;
    }

    public function setMatriculeFormateur(string $matricule_Formateur): self
    {
        $this->matricule_Formateur = $matricule_Formateur;

        return $this;
    }
}
