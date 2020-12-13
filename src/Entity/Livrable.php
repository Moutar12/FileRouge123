<?php

namespace App\Entity;

use App\Repository\LivrableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LivrableRepository::class)
 */
class Livrable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=BriefLivrable::class, mappedBy="livrable")
     */
    private $briefLivrable;

    public function __construct()
    {
        $this->briefLivrable = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|BriefLivrable[]
     */
    public function getBriefLivrable(): Collection
    {
        return $this->briefLivrable;
    }

    public function addBriefLivrable(BriefLivrable $briefLivrable): self
    {
        if (!$this->briefLivrable->contains($briefLivrable)) {
            $this->briefLivrable[] = $briefLivrable;
            $briefLivrable->setLivrable($this);
        }

        return $this;
    }

    public function removeBriefLivrable(BriefLivrable $briefLivrable): self
    {
        if ($this->briefLivrable->removeElement($briefLivrable)) {
            // set the owning side to null (unless already changed)
            if ($briefLivrable->getLivrable() === $this) {
                $briefLivrable->setLivrable(null);
            }
        }

        return $this;
    }
}
