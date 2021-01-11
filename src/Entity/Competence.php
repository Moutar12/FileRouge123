<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CompetenceRepository::class)
 * @ApiResource(
 * itemOperations={
 *  "Get_competence_1":{
 *          "method":"GET",
 *          "path":"/admin/competences/{id}",
 *          "normalization_context"={"groups"="cmptcs1:read"},
 *          "access_control"="(is_granted('ROLE_ADMIN') )",
 *          "access_control_message"="Vous n'étes pas autorisé à cette Ressource",
 *     },
 *     "Put_competence_1":{
 *          "method":"PUT",
 *          "path":"/admin/competences/{id}",
 *          "normalization_context"={"groups"="cmptcs1:read"},
 *          "access_control"="(is_granted('ROLE_ADMIN') )",
 *          "access_control_message"="Vous n'étes pas autorisé à cette Ressource",
 *     },
 *     },
 *     collectionOperations={
 *      "Get_competence":{
 *          "method":"GET",
 *          "path":"/admin/competences",
 *          "normalization_context"={"groups"="cmptcs:read"},
 *          "access_control"="(is_granted('ROLE_ADMIN') )",
 *          "access_control_message"="Vous n'étes pas autorisé à cette Ressource",
 *     },
 *     "Post_competence":{
 *          "method":"POST",
 *          "path":"/admin/competences",
 *          "denormalization_context"={"groups"={"cmptc:write"}},
 *          "access_control"="(is_granted('ROLE_ADMIN') )",
 *          "access_control_message"="Vous n'étes pas autorisé à cette Ressource",
 *     },
 *     }
 *
 * )
 */
class Competence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"grpcmptcs:read","cmptcs1:read","grpcmptcs3:read","grpcmptcs2:read","grpcmptcs:write","grpcmptcs:write","grcreferenciel:read"})
     *
     */
    private $id;


    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetence::class, mappedBy="competence")
     * @Groups({"grcreferenciel:read"})
     */
    private $groupeCompetences;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"grpcmptcs:read","cmptcs:read","cmptc:write","cmptcs1:read","grpcmptcs1:read","grpcmptcs2:read","grpcmptcs3:read","grcreferenciel:read"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Niveau::class, mappedBy="competence", cascade={"persist"})
     * @Groups({"cmptcs:read","cmptc:write","cmptcs1:read"})
     * @Assert\Count(
     *     min="3",
     *     max="3"
     * )
     */
    private $niveau;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    public function __construct()
    {
        $this->niveau = new ArrayCollection();
        $this->groupeCompetences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @return Collection|GroupeCompetence[]
     */
    public function getGroupeCompetences(): Collection
    {
        return $this->groupeCompetences;
    }

    public function addGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if (!$this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences[] = $groupeCompetence;
            $groupeCompetence->addCompetence($this);
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if ($this->groupeCompetences->removeElement($groupeCompetence)) {
            $groupeCompetence->removeCompetence($this);
        }

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
     * @return Collection|Niveau[]
     */
    public function getNiveau(): Collection
    {
        return $this->niveau;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->niveau->contains($niveau)) {
            $this->niveau[] = $niveau;
            $niveau->setCompetence($this);
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveau->removeElement($niveau)) {
            // set the owning side to null (unless already changed)
            if ($niveau->getCompetence() === $this) {
                $niveau->setCompetence(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
