<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 */
class Service
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
     * @ORM\OneToMany(targetEntity="App\Entity\Medcin", mappedBy="service")
     
     */
    private $medcins;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Specialite", mappedBy="service")
     */
    private $specialites;

    public function __construct()
    {
        $this->medcins = new ArrayCollection();
        $this->specialites = new ArrayCollection();
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
    public function getMedcins(): Collection
    {
        return $this->medcins;
    }

    public function addMedcin(Medcin $medcin): self
    {
        if (!$this->medcins->contains($medcin)) {
            $this->medcins[] = $medcin;
            $medcin->setService($this);
        }

        return $this;
    }

    public function removeMedcin(Medcin $medcin): self
    {
        if ($this->medcins->contains($medcin)) {
            $this->medcins->removeElement($medcin);
            // set the owning side to null (unless already changed)
            if ($medcin->getService() === $this) {
                $medcin->setService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Specialite[]
     */
    public function getSpecialites(): Collection
    {
        return $this->specialites;
    }

    public function addSpecialite(Specialite $specialite): self
    {
        if (!$this->specialites->contains($specialite)) {
            $this->specialites[] = $specialite;
            $specialite->setService($this);
        }

        return $this;
    }

    public function removeSpecialite(Specialite $specialite): self
    {
        if ($this->specialites->contains($specialite)) {
            $this->specialites->removeElement($specialite);
            // set the owning side to null (unless already changed)
            if ($specialite->getService() === $this) {
                $specialite->setService(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
       return $this->libelle;
    }

}
