<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProfilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProfilRepository::class)
 * @UniqueEntity("libelle", message="Ce champ doit etre unique")
 * * @ApiFilter (SearchFilter::class, properties={"archive": "exact"})
 * @ApiResource(
 *     itemOperations={
 *      "get_user_profil":{
 *      "method":"get",
 *      "path":"/admin/profils/{id}",
 *      "normalization_context"={"groups":"id1:read"},
 *     },
 * "get1":{
 *              "method":"GET",
 *              "path":"/admin/profils/{id}/users",
 *              "normalization_context"={"groups":"profil_id:read"},
 *              "access_control"="(is_granted('ROLE_ADMIN'))",
 *              "access_control_message"="Vous n'étes pas autorisé à cette ressource"
 *     },
 * 
 *     "put_user_profil":{
 *      "method":"put",
 *      "path":"/admin/profils/{id}",
 *      "normalization_context"={"groups":"profil_put:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN', 'ROLE_FORMATEUR'))",
 *      "access_control_message"="Vous n'étes pas autorisé à cette ressource"
 *     },
 *     "delete_profils":{
 *      "method"="DELETE",
 *      "path":"/admin/profils/{id}",
 *      "normalization_context"={"groups":"profil_put:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN'))",
 *      "access_control_message"="Vous n'étes pas autorisé à cette ressource"
 *     }
 *
 *     },
 *
 *collectionOperations={
 *        "get":{
 *              "method":"GET",
 *              "path":"/admin/profils",
 *              "normalization_context"={"groups":"profil:read"},
 *              "access_control"="(is_granted('ROLE_ADMIN'))",
 *              "access_control_message"="Vous n'étes pas autorisé à cette ressource"
 *     },
 *     "post":{
 *        "path":"/admin/profils",
 *        "access_control"="(is_granted('ROLE_ADMIN'))",
 *        "access_control_message"="Vous n'étes pas autorisé à cette ressource"
 *
 *     },
 *     }
 * )
 */
class Profil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *@Groups({"users:read","profil:read","id1:read","profil_put:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"users:read","profil:read","id1:read","profil_put:read","profil_id:read"})
     */
    private $libelle;



    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="profil")
     * @Groups({"profil_id:read"})
     */
    private $users;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $archive;

    public function __construct()
    {
        $this->archive = true;
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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


    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setProfil($this);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getProfil() === $this) {
                $user->setProfil(null);
            }
        }

        return $this;
    }

    public function getArchive(): ?bool
    {
        return $this->archive;
    }

    public function setArchive(?bool $archive): self
    {
        $this->archive = $archive;

        return $this;
    }
}
