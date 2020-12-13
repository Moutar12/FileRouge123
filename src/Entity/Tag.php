<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 * @ApiResource(
 *     collectionOperations={
 *      "Post_tag":{
 *          "method":"POST",
 *          "path": "/admin/tags",
 *          "denormalization_context"={"groups"="tags:write"},
 *          "access_control"="(is_granted('ROLE_ADMIN') )",
 *          "access_control_message"="Vous n'étes pas autorisé à cette Ressource",
 *     },
 *     "Get_tag":{
*       "method":"GET",
 *          "path": "/admin/tags",
 *          "normalization_context"={"groups"="tags:read"},
 *          "access_control"="(is_granted('ROLE_ADMIN') )",
 *          "access_control_message"="Vous n'étes pas autorisé à cette Ressource",
 *     },
 *     },
 *     itemOperations={
 *      "Get_tag_id":{
 *       "method":"GET",
 *          "path": "/admin/tags/{id}",
 *          "normalization_context"={"groups"="tags:read"},
 *          "access_control"="(is_granted('ROLE_ADMIN') )",
 *          "access_control_message"="Vous n'étes pas autorisé à cette Ressource",
 *     },
 *     "PUT_tag":{
 *       "method":"PUT",
 *          "path": "/admin/tags/{id}",
 *          "normalization_context"={"groups"="tags:read"},
 *          "access_control"="(is_granted('ROLE_ADMIN') )",
 *          "access_control_message"="Vous n'étes pas autorisé à cette Ressource",
 *     },
 *     }
 * )
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *@Groups({"groupetags:write","groupetags:read"})
     */
    private $id;


    /**
     * @ORM\ManyToMany(targetEntity=GroupeTag::class, mappedBy="tag")
     * @Groups({"tags:write","tags:read","groupetags:read"})
     */
    private $groupeTags;

    /**
     * @ORM\ManyToMany(targetEntity=Brief::class, mappedBy="tag")
     * @Groups({"tags:write","tags:read"})
     */
    private $briefs;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"tags:write","tags:read"})
     * @Groups({"groupetags:write","groupe_tags:read"})
     */
    private $libelle;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->groupeTags = new ArrayCollection();
        $this->briefs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|self[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(self $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->setBrief($this);
        }

        return $this;
    }

    public function removeTag(self $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            // set the owning side to null (unless already changed)
            if ($tag->getBrief() === $this) {
                $tag->setBrief(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|GroupeTag[]
     */
    public function getGroupeTags(): Collection
    {
        return $this->groupeTags;
    }

    public function addGroupeTag(GroupeTag $groupeTag): self
    {
        if (!$this->groupeTags->contains($groupeTag)) {
            $this->groupeTags[] = $groupeTag;
            $groupeTag->addTag($this);
        }

        return $this;
    }

    public function removeGroupeTag(GroupeTag $groupeTag): self
    {
        if ($this->groupeTags->removeElement($groupeTag)) {
            $groupeTag->removeTag($this);
        }

        return $this;
    }

    /**
     * @return Collection|Brief[]
     */
    public function getBriefs(): Collection
    {
        return $this->briefs;
    }

    public function addBrief(Brief $brief): self
    {
        if (!$this->briefs->contains($brief)) {
            $this->briefs[] = $brief;
            $brief->addTag($this);
        }

        return $this;
    }

    public function removeBrief(Brief $brief): self
    {
        if ($this->briefs->removeElement($brief)) {
            $brief->removeTag($this);
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
}
