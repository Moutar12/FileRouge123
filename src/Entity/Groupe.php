<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=GroupeRepository::class)
 * @ApiResource(
 *     collectionOperations={
 *
 *     "post_groupes":{
 *      "method":"POST",
 *      "path":"/admin/groupes",
 *      "denormalization_context"={"groups"={"groupes:write"}},
 *     },
 *
 *      "Get_groupe":{
 *      "method":"GET",
 *      "path":"/admin/groupes",
 *      "normalization_context"={"groups"="groupe:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN') )",
 *      "access_control_message"="Vous n'étes pas autorisé à cette Ressource",
 *     },
 *
 *  "Get_groupe_App":{
 *      "method":"GET",
 *      "path":"/admin/groupes/apprenants",
 *      "normalization_context"={"groups"="groupeApp:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN') )",
 *      "access_control_message"="Vous n'étes pas autorisé à cette Ressource",
 *     },
 *
 *     },
 * itemOperations={
 *  "Delete_groupe_App":{
 *      "method":"Delete",
 *      "path":"admin/groupes/{id_1}/apprenants/{id}",
 *      "normalization_context"={"groups"="groupedelete:read"},
 *
 *     },
 *
 * "Get_groupe_App_id":{
 *      "method":"GET",
 *      "path":"/admin/groupes/{id}",
 *      "normalization_context"={"groups"="groupe_app_id:read"},
 *
 *     },
 *
 *"Put_groupe":{
 *      "method":"PUT",
 *      "path":"/admin/groupes/{id}",
 *      "normalization_context"={"groups"="groupe_put:read"},
 *
 *     },
 *     }
 * )
 */
class Groupe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"groupedelete:read"})
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, inversedBy="groupes", cascade="persist")
     * @Groups({"groupe_app_id:read","groupes:write"})
     *
     */
    private $formateur;

    /**
     * @ORM\OneToMany(targetEntity=EtatBriefGroupe::class, mappedBy="groupe")
     */
    private $etatBriefGroupe;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="groupe")
     */
    private $promo;

    /**
     * @ORM\ManyToMany(targetEntity=Apprenant::class, mappedBy="groupe",cascade="persist")
     * @Groups({"groupe:read","groupeApp:read","groupe_app_id:read","groupes:write"})
     * @ApiSubresource()
     */
    private $apprenants;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read","groupes:write","groupe_app_id:read",})
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read","groupes:write"})
     */
    private $nomGroupe;

    public function __construct()
    {
        $this->formateur = new ArrayCollection();
        $this->etatBriefGroupe = new ArrayCollection();
        $this->apprenants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|EtatBriefGroupe[]
     */
    public function getEtatBriefGroupe(): Collection
    {
        return $this->etatBriefGroupe;
    }

    public function addEtatBriefGroupe(EtatBriefGroupe $etatBriefGroupe): self
    {
        if (!$this->etatBriefGroupe->contains($etatBriefGroupe)) {
            $this->etatBriefGroupe[] = $etatBriefGroupe;
            $etatBriefGroupe->setGroupe($this);
        }

        return $this;
    }

    public function removeEtatBriefGroupe(EtatBriefGroupe $etatBriefGroupe): self
    {
        if ($this->etatBriefGroupe->removeElement($etatBriefGroupe)) {
            // set the owning side to null (unless already changed)
            if ($etatBriefGroupe->getGroupe() === $this) {
                $etatBriefGroupe->setGroupe(null);
            }
        }

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

    /**
     * @return Collection|Apprenant[]
     */
    public function getApprenants(): Collection
    {
        return $this->apprenants;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenants->contains($apprenant)) {
            $this->apprenants[] = $apprenant;
            $apprenant->addGroupe($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenants->removeElement($apprenant)) {
            $apprenant->removeGroupe($this);
        }

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getNomGroupe(): ?string
    {
        return $this->nomGroupe;
    }

    public function setNomGroupe(string $nomGroupe): self
    {
        $this->nomGroupe = $nomGroupe;

        return $this;
    }
}
