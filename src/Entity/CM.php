<?php

namespace App\Entity;

use App\Repository\CMRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CMRepository::class)
 */
class CM
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
    private $matricule_CM;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatriculeCM(): ?string
    {
        return $this->matricule_CM;
    }

    public function setMatriculeCM(string $matricule_CM): self
    {
        $this->matricule_CM = $matricule_CM;

        return $this;
    }
}
