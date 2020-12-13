<?php

namespace App\Entity;

use App\Repository\BriefLivrableRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BriefLivrableRepository::class)
 */
class BriefLivrable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Brief::class, inversedBy="briefLivrables")
     */
    private $brief;

    /**
     * @ORM\ManyToOne(targetEntity=Livrable::class, inversedBy="briefLivrable")
     */
    private $livrable;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrief(): ?Brief
    {
        return $this->brief;
    }

    public function setBrief(?Brief $brief): self
    {
        $this->brief = $brief;

        return $this;
    }

    public function getLivrable(): ?Livrable
    {
        return $this->livrable;
    }

    public function setLivrable(?Livrable $livrable): self
    {
        $this->livrable = $livrable;

        return $this;
    }
}
