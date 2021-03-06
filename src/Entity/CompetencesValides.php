<?php

namespace App\Entity;

use App\Repository\CompetencesValidesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompetencesValidesRepository::class)
 */
class CompetencesValides
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $niveau1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $niveau2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $niveau3;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="competenceValide")
     */
    private $promo;

    /**
     * @ORM\ManyToOne(targetEntity=Apprenant::class, inversedBy="competenceValide")
     */
    private $apprenant;

    /**
     * @ORM\ManyToOne(targetEntity=Referentiel::class, inversedBy="competencesValides")
     */
    private $referentiel;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNiveau1(): ?string
    {
        return $this->niveau1;
    }

    public function setNiveau1(string $niveau1): self
    {
        $this->niveau1 = $niveau1;

        return $this;
    }

    public function getNiveau2(): ?string
    {
        return $this->niveau2;
    }

    public function setNiveau2(string $niveau2): self
    {
        $this->niveau2 = $niveau2;

        return $this;
    }

    public function getNiveau3(): ?string
    {
        return $this->niveau3;
    }

    public function setNiveau3(string $niveau3): self
    {
        $this->niveau3 = $niveau3;

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

    public function getApprenant(): ?Apprenant
    {
        return $this->apprenant;
    }

    public function setApprenant(?Apprenant $apprenant): self
    {
        $this->apprenant = $apprenant;

        return $this;
    }

    public function getReferentiel(): ?Referentiel
    {
        return $this->referentiel;
    }

    public function setReferentiel(?Referentiel $referentiel): self
    {
        $this->referentiel = $referentiel;

        return $this;
    }
}
