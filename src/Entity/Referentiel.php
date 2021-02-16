<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ReferentielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ReferentielRepository::class)
 * @ApiResource (
*collectionOperations={
* "getAllReferenciel"={
*      "method":"GET",
 *     "path":"/admin/referenciels",
 *      "normalizationContext"={"groups":{"referenciel:read"}},
 *       "access_control"="(is_granted('ROLE_ADMIN') )",
 *     },
 *  "addReferentiel":{
 *        "method":"POST",
 *        "route_name"="postRef",
 *         "denormalizationContext"={"groups"={"referenciel:write"}},
 *         "access_control"="(is_granted('ROLE_ADMIN') )",
 *         "access_control_message"="Vous n'avez pas access à cette Ressource",
 *     },
 *                   
 *           
 *          "get_groupe_competence_ref"={
 *                          "method"="GET",
 *                          "normalizationContext"={"groups":{"grcreferenciels:read"}},
 *                          "path"="/admin/referentiels/grpecompetences",
 *
 *     },
 *     },
 *  itemOperations={
 *  "ref_id"={
 *             "method"="GET",
 *             "normalizationContext"={"groups":{"grcreferenciel:read"}},
 *             "path"="/admin/referentiels/{id}",
 *     },
 *     "ref_grcomp_id"={
 *             "method"="GET",
 *             "normalizationContext"={"groups":{"grcreferenciel_id:read"}},
 *             "path"="/admin/referentiels/{id_1}/grpecompetences/{id}",
 *     },
 * "editeReferentiel":{
 *        "method":"PUT",
 *        "route_name"="puttRef",
 *         "denormalizationContext"={"groups"={"referenciel:write"}},
 *         "access_control"="(is_granted('ROLE_ADMIN') )",
 *         "access_control_message"="Vous n'avez pas access à cette Ressource",
 *     },
 * "sup_ref"={
 *             "method"="Delete",
 *             "path"="/admin/referentiels/{id}",
 *     },
 *  
 *     }
 * )
 */
class Referentiel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups ({"referentiel:write","grcreferenciels:read",
     *    "grcreferenciel:read","referenciel:write","supreferenciel:read"})
     */
    private $id;
    
 
 /**
  * @ORM\Column(type="string", length=255)
  * @Groups({"referenciel:read","referentiel:write","grcreferenciels:read","grcreferenciel:read",
  *          "grcreferenciel_id:read","referenciel:write"})
  */
 private $presentation;
 
 /**
  * @ORM\Column(type="string", length=255)
  * @Groups({"referenciel:read","referentiel:write","grcreferenciels:read","grcreferenciel:read",
  *          "grcreferenciel_id:read","referenciel:write"})
  */
 private $critereEvaluation;
 
 /**
  * @ORM\Column(type="string", length=255)
  * @Groups({"referenciel:read","referentiel:write","grcreferenciels:read","grcreferenciel:read",
  *          "grcreferenciel_id:read","referenciel:write"})
  */
 private $critereAdmission;
 
 
 
 /**
  * @ORM\Column(type="string", length=255)
  * @Groups({"referenciel:read","referentiel:write","grcreferenciels:read","grcreferenciel:read",
  *          "grcreferenciel_id:read","referenciel:write"})
  */
 private $libelle;
    /**
     * @ORM\ManyToMany(targetEntity=Promo::class, mappedBy="referentiel")
     */
    private $promos;
    
    /**
     * @ORM\OneToMany(targetEntity=CompetencesValides::class, mappedBy="referentiel")
     */
    private $competencesValides;
    
    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetence::class, inversedBy="referentiels")
     * @Groups({"referenciel:read","referentiel:write","grcreferenciels:read","grcreferenciel:read",
     *      "grcreferenciel_id:read","referenciel:write"})
     */
    private $groupeCompetence;

    /**
     * @ORM\Column(type="blob")
     * @Groups({"referentiel:write","grcreferenciels:read","grcreferenciel:read",
     *      "grcreferenciel_id:read","referenciel:write"})
     */
    private $programme;




    public function __construct()
    {
        $this->promos = new ArrayCollection();
        $this->competencesValides = new ArrayCollection();
        $this->groupeCompetence = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getCritereEvaluation(): ?string
    {
        return $this->critereEvaluation;
    }

    public function setCritereEvaluation(string $critereEvaluation): self
    {
        $this->critereEvaluation = $critereEvaluation;

        return $this;
    }

    public function getCritereAdmission(): ?string
    {
        return $this->critereAdmission;
    }

    public function setCritereAdmission(string $critereAdmission): self
    {
        $this->critereAdmission = $critereAdmission;

        return $this;
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
     * @return Collection|Promo[]
     */
    public function getPromos(): Collection
    {
        return $this->promos;
    }

    public function addPromo(Promo $promo): self
    {
        if (!$this->promos->contains($promo)) {
            $this->promos[] = $promo;
            $promo->addReferentiel($this);
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promos->removeElement($promo)) {
            $promo->removeReferentiel($this);
        }

        return $this;
    }

    /**
     * @return Collection|CompetencesValides[]
     */
    public function getCompetencesValides(): Collection
    {
        return $this->competencesValides;
    }

    public function addCompetencesValide(CompetencesValides $competencesValide): self
    {
        if (!$this->competencesValides->contains($competencesValide)) {
            $this->competencesValides[] = $competencesValide;
            $competencesValide->setReferentiel($this);
        }

        return $this;
    }

    public function removeCompetencesValide(CompetencesValides $competencesValide): self
    {
        if ($this->competencesValides->removeElement($competencesValide)) {
            // set the owning side to null (unless already changed)
            if ($competencesValide->getReferentiel() === $this) {
                $competencesValide->setReferentiel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|GroupeCompetence[]
     */
    public function getGroupeCompetence(): Collection
    {
        return $this->groupeCompetence;
    }

    public function addGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if (!$this->groupeCompetence->contains($groupeCompetence)) {
            $this->groupeCompetence[] = $groupeCompetence;
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        $this->groupeCompetence->removeElement($groupeCompetence);

        return $this;
    }

    public function getProgramme()
    {
        if($this->programme !== null){
            return base64_encode(stream_get_contents($this->programme));
        }else
        {
           return $this->programme;
        }
        
    }

    public function setProgramme($programme): self
    {
        $this->programme = $programme;

        return $this;
    }

    


   
}
