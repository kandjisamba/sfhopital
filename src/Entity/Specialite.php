<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SpecialiteRepository")
 */
class Specialite
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=3, max=255)
      * @Assert\NotBlank(message="le Libelle est obligatoire")
     * @Assert\Regex(pattern="#^[a-zA-Z]+$#", message="Libelle non valid")
     */
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Medcin", inversedBy="specialites")
     */
    private $medcin;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Service", inversedBy="specialites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $service;

    public function __construct()
    {
        $this->medcin = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|Medcin[]
     */
    public function getMedcin(): Collection
    {
        return $this->medcin;
    }

    public function addMedcin(Medcin $medcin): self
    {
        if (!$this->medcin->contains($medcin)) {
            $this->medcin[] = $medcin;
        }

        return $this;
    }

    public function removeMedcin(Medcin $medcin): self
    {
        if ($this->medcin->contains($medcin)) {
            $this->medcin->removeElement($medcin);
        }

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function __toString()
    {
       return $this->libelle;
    }
}
