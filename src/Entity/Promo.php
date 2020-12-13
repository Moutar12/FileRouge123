<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\PromoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PromoRepository::class)
 */
class Promo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"groupe:read"})
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=BriefMaPromo::class, mappedBy="promo")
     */
    private $briefMapromo;

    /**
     * @ORM\OneToMany(targetEntity=Groupe::class, mappedBy="promo")
     * @Groups({"groupes:write"})
     *
     */
    private $groupe;

    /**
     * @ORM\ManyToMany(targetEntity=Referentiel::class, inversedBy="promos")
     * @Groups({"groupe:read"})
     */
    private $referentiel;

    /**
     * @ORM\OneToMany(targetEntity=Chat::class, mappedBy="promo")
     */
    private $chat;

    /**
     * @ORM\OneToMany(targetEntity=CompetencesValides::class, mappedBy="promo")
     */
    private $competenceValide;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, inversedBy="promos")
     */
    private $formateur;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read"})
     */
    private $nomPromo;

    /**
     * @ORM\Column(type="date")
     * @Groups({"groupe:read"})
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
     * @Groups({"groupe:read"})
     */
    private $dateFin;



    public function __construct()
    {
        $this->briefMapromo = new ArrayCollection();
        $this->groupe = new ArrayCollection();
        $this->referentiel = new ArrayCollection();
        $this->chat = new ArrayCollection();
        $this->competenceValide = new ArrayCollection();
        $this->formateur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|BriefMaPromo[]
     */
    public function getBriefMapromo(): Collection
    {
        return $this->briefMapromo;
    }

    public function addBriefMapromo(BriefMaPromo $briefMapromo): self
    {
        if (!$this->briefMapromo->contains($briefMapromo)) {
            $this->briefMapromo[] = $briefMapromo;
            $briefMapromo->setPromo($this);
        }

        return $this;
    }

    public function removeBriefMapromo(BriefMaPromo $briefMapromo): self
    {
        if ($this->briefMapromo->removeElement($briefMapromo)) {
            // set the owning side to null (unless already changed)
            if ($briefMapromo->getPromo() === $this) {
                $briefMapromo->setPromo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupe(): Collection
    {
        return $this->groupe;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupe->contains($groupe)) {
            $this->groupe[] = $groupe;
            $groupe->setPromo($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupe->removeElement($groupe)) {
            // set the owning side to null (unless already changed)
            if ($groupe->getPromo() === $this) {
                $groupe->setPromo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Referentiel[]
     */
    public function getReferentiel(): Collection
    {
        return $this->referentiel;
    }

    public function addReferentiel(Referentiel $referentiel): self
    {
        if (!$this->referentiel->contains($referentiel)) {
            $this->referentiel[] = $referentiel;
        }

        return $this;
    }

    public function removeReferentiel(Referentiel $referentiel): self
    {
        $this->referentiel->removeElement($referentiel);

        return $this;
    }

    /**
     * @return Collection|Chat[]
     */
    public function getChat(): Collection
    {
        return $this->chat;
    }

    public function addChat(Chat $chat): self
    {
        if (!$this->chat->contains($chat)) {
            $this->chat[] = $chat;
            $chat->setPromo($this);
        }

        return $this;
    }

    public function removeChat(Chat $chat): self
    {
        if ($this->chat->removeElement($chat)) {
            // set the owning side to null (unless already changed)
            if ($chat->getPromo() === $this) {
                $chat->setPromo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CompetencesValides[]
     */
    public function getCompetenceValide(): Collection
    {
        return $this->competenceValide;
    }

    public function addCompetenceValide(CompetencesValides $competenceValide): self
    {
        if (!$this->competenceValide->contains($competenceValide)) {
            $this->competenceValide[] = $competenceValide;
            $competenceValide->setPromo($this);
        }

        return $this;
    }

    public function removeCompetenceValide(CompetencesValides $competenceValide): self
    {
        if ($this->competenceValide->removeElement($competenceValide)) {
            // set the owning side to null (unless already changed)
            if ($competenceValide->getPromo() === $this) {
                $competenceValide->setPromo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Formateur[]
     */
    public function getFormateur(): Collection
    {
        return $this->formateur;
    }

    public function addFormateur(Formateur $formateur): self
    {
        if (!$this->formateur->contains($formateur)) {
            $this->formateur[] = $formateur;
        }

        return $this;
    }

    public function removeFormateur(Formateur $formateur): self
    {
        $this->formateur->removeElement($formateur);

        return $this;
    }

    public function getNomPromo(): ?string
    {
        return $this->nomPromo;
    }

    public function setNomPromo(string $nomPromo): self
    {
        $this->nomPromo = $nomPromo;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }


}
