<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupeCompetenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=GroupeCompetenceRepository::class)
 * @ApiResource(
 *
 *
 *     collectionOperations={
 *     "Get_grpCompetence":{
 *         "method":"GET",
 *         "path":"/admin/grpecompetences",
 *         "normalization_context"={"groups"="grpcmptcs:read"},
 *          "access_control"="(is_granted('ROLE_ADMIN','FORMATEUR','CM') )",
 *          "access_control_message"="Vous n'étes pas autorisé à cette Ressource",
 *     },
 *     "Post_grpCompetence":{
 *         "method":"POST",
 *         "path":"/admin/grpecompetences",
 *         "denormalization_context"={"groups"="grpcmptcs:write"},
 *          "access_control"="(is_granted('ROLE_ADMIN') )",
 *          "access_control_message"="Vous n'étes pas autorisé à cette Ressource",
 *     },
 *     "Get_grpCompetence_1":{
 *         "method":"Get",
 *         "path":"/admin/grpecompetences/competences",
 *         "normalization_context"={"groups"="grpcmptcs1:read"},
 *          "access_control"="(is_granted('ROLE_ADMIN') )",
 *          "access_control_message"="Vous n'étes pas autorisé à cette Ressource",
 *     }
 *     },
 *     itemOperations={
 *     "Get_grpeCompetence_id":{
 *      "method":"GET",
 *      "path":"/admin/grpecompetences/{id}",
 *      "normalization_context"={"groups"="grpcmptcs2:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN','FORMATEUR','CM') )",
 *      "access_control_message"="Vous n'étes pas autorisé à cette Ressource",
 *     },
 *     "Get_grpeCompetence_competence_id":{
 *      "method":"GET",
 *      "path":"/admin/grpecompetences/{id}/competences",
 *      "normalization_context"={"groups"="grpcmptcs3:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN','FORMATEUR','CM') )",
 *      "access_control_message"="Vous n'étes pas autorisé à cette Ressource",
 *     },
 *     "Put_grpeCompetence":{
 *      "method":"PUT",
 *      "path":"/admin/grpecompetences/{id}",
 *      "normalization_context"={"groups"="grpcmptcs4:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN','FORMATEUR','CM') )",
 *      "access_control_message"="Vous n'étes pas autorisé à cette Ressource",
 *     },
 *     }
 * )
 */
class GroupeCompetence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"grpcmptcs3:read","referentiel:write","referenciel:read","grcreferenciel:read"})
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Competence::class, inversedBy="groupeCompetences",cascade={"persist"})
     *  @Groups({"grpcmptcs:read","grpcmptcs1:read","grpcmptcs2:read","grpcmptcs3:read","grpcmptcs:write","grcreferenciel:read"})
     */
    private $competence;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"grpcmptcs1:read","grpcmptcs3:read","grpcmptcs:write","referenciel:read","grcreferenciel:read"})
     */
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity=Referentiel::class, mappedBy="groupeCompetence")
     * @Groups({"referenciel:read"})
     */
    private $referentiels;

    public function __construct()
    {
        $this->competence = new ArrayCollection();
        $this->referentiels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Competence[]
     */
    public function getCompetence(): Collection
    {
        return $this->competence;
    }

    public function addCompetence(Competence $competence): self
    {
        if (!$this->competence->contains($competence)) {
            $this->competence[] = $competence;
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        $this->competence->removeElement($competence);

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
     * @return Collection|Referentiel[]
     */
    public function getReferentiels(): Collection
    {
        return $this->referentiels;
    }

    public function addReferentiel(Referentiel $referentiel): self
    {
        if (!$this->referentiels->contains($referentiel)) {
            $this->referentiels[] = $referentiel;
            $referentiel->addGroupeCompetence($this);
        }

        return $this;
    }

    public function removeReferentiel(Referentiel $referentiel): self
    {
        if ($this->referentiels->removeElement($referentiel)) {
            $referentiel->removeGroupeCompetence($this);
        }

        return $this;
    }
}
