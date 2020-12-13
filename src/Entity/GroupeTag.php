<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupeTagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=GroupeTagRepository::class)
 * @ApiResource(
 *     collectionOperations={
 *  "Post_Groupetag":{
 *          "method":"POST",
 *          "path":"/admin/grptags",
 *          "denormalization_context"={"groups"={"groupetags:write"}},
 *          "access_control"="(is_granted('ROLE_ADMIN') )",
 *          "access_control_message"="Vous n'étes pas autorisé à cette Ressource",
 *     },
 *     "Get_Groupetag":{
 *          "method":"GET",
 *          "path":"/admin/grptags",
 *          "normalization_context"={"groups"="groupetags:read"},
 *          "access_control"="(is_granted('ROLE_ADMIN') )",
 *          "access_control_message"="Vous n'étes pas autorisé à cette Ressource",
 *     },
 *     },
 *     itemOperations={
 *      "Get_id_grtags":{
 *      "method":"GET",
 *          "path":"/admin/grptags/{id}",
 *          "normalization_context"={"groups"="groupetags:read"},
 *          "access_control"="(is_granted('ROLE_ADMIN') )",
 *          "access_control_message"="Vous n'étes pas autorisé à cette Ressource",
 *     },
 *     "Get_id_grtags_tag":{
 *      "method":"GET",
 *          "path":"/admin/grptags/{id}/tags",
 *          "normalization_context"={"groups"="groupe_tags:read"},
 *          "access_control"="(is_granted('ROLE_ADMIN') )",
 *          "access_control_message"="Vous n'étes pas autorisé à cette Ressource",
 *     },
 *     "Put_id_grtags_tag":{
 *      "method":"PUT",
 *          "path":"/admin/grptags/{id}",
 *          "access_control"="(is_granted('ROLE_ADMIN') )",
 *          "access_control_message"="Vous n'étes pas autorisé à cette Ressource",
 *     }
 *     }
 * )
 */
class GroupeTag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"tags:write"})
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="groupeTags",cascade={"persist"})
     * @Groups({"groupetags:write","tags:write","groupe_tags:read"})
     */
    private $tag;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupetags:write","groupetags:read","groupe_tags:read"})
     * @Groups({"tags:write"})
     */
    private $libelle;

    public function __construct()
    {
        $this->tag = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tag->contains($tag)) {
            $this->tag[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tag->removeElement($tag);

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
}
