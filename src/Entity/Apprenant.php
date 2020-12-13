<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ApprenantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

use ApiPlatform\Core\Annotation\ApiSubresource;

/**
 * @ORM\Entity(repositoryClass=ApprenantRepository::class)
 *@ApiResource(
 *     collectionOperations={
 *         "addApprenant":{
 *              "method":"POST",
 *              "route_name"="post_apprenant",
 *              "deserialize"=false,
 *              "access_control"="(is_granted('ROLE_ADMIN') )",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource",
 *
 *     },
 *     "get_Apprenants":{
 *     "method":"GET",
 *     "path":"/apprenants",
 *     "normalization_context"={"groups"="appnt:read"},
 *     "access_control"="(is_granted('ROLE_ADMIN') )",
 *     "access_control_message"="Vous n'étes pas autorisé à cette Ressource",
 *
 *     },
 *     },
 *     itemOperations={

 *       "apprenat_id":{
 *           "method":"GET",
 *           "path":"apprenants/{id}",
 *             "normalization_context"={"groups"={"appnt_id:read"}},
 *
 *         }
 *     }
 * )
 */
class Apprenant extends User
{
    /**
     * @ORM\OneToMany(targetEntity=ApprenantLivrablePartiel::class, mappedBy="apprenant")
     */
    private $apprenantLivrablePartiels;

    /**
     * @ORM\OneToMany(targetEntity=CompetencesValides::class, mappedBy="apprenant")
     */
    private $competenceValide;

    /**
     * @ORM\OneToMany(targetEntity=BriefApprenant::class, mappedBy="apprenant")
     */
    private $briefApprenants;

    /**
     * @ORM\ManyToMany(targetEntity=Groupe::class, inversedBy="apprenants",cascade="persist")
     * @Groups({"groupe:read","groupeApp:read"})
     */
    private $groupe;

    public function __construct()
    {
        parent::__construct();
        $this->apprenantLivrablePartiels = new ArrayCollection();
        $this->competenceValide = new ArrayCollection();
        $this->briefApprenants = new ArrayCollection();
        $this->groupe = new ArrayCollection();
    }

    /**
     * @return Collection|ApprenantLivrablePartiel[]
     */
    public function getApprenantLivrablePartiels(): Collection
    {
        return $this->apprenantLivrablePartiels;
    }

    public function addApprenantLivrablePartiel(ApprenantLivrablePartiel $apprenantLivrablePartiel): self
    {
        if (!$this->apprenantLivrablePartiels->contains($apprenantLivrablePartiel)) {
            $this->apprenantLivrablePartiels[] = $apprenantLivrablePartiel;
            $apprenantLivrablePartiel->setApprenant($this);
        }

        return $this;
    }

    public function removeApprenantLivrablePartiel(ApprenantLivrablePartiel $apprenantLivrablePartiel): self
    {
        if ($this->apprenantLivrablePartiels->removeElement($apprenantLivrablePartiel)) {
            // set the owning side to null (unless already changed)
            if ($apprenantLivrablePartiel->getApprenant() === $this) {
                $apprenantLivrablePartiel->setApprenant(null);
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
            $competenceValide->setApprenant($this);
        }

        return $this;
    }

    public function removeCompetenceValide(CompetencesValides $competenceValide): self
    {
        if ($this->competenceValide->removeElement($competenceValide)) {
            // set the owning side to null (unless already changed)
            if ($competenceValide->getApprenant() === $this) {
                $competenceValide->setApprenant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BriefApprenant[]
     */
    public function getBriefApprenants(): Collection
    {
        return $this->briefApprenants;
    }

    public function addBriefApprenant(BriefApprenant $briefApprenant): self
    {
        if (!$this->briefApprenants->contains($briefApprenant)) {
            $this->briefApprenants[] = $briefApprenant;
            $briefApprenant->setApprenant($this);
        }

        return $this;
    }

    public function removeBriefApprenant(BriefApprenant $briefApprenant): self
    {
        if ($this->briefApprenants->removeElement($briefApprenant)) {
            // set the owning side to null (unless already changed)
            if ($briefApprenant->getApprenant() === $this) {
                $briefApprenant->setApprenant(null);
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
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        $this->groupe->removeElement($groupe);

        return $this;
    }
}
