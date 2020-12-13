<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProfilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProfilRepository::class)
 * @UniqueEntity("libelle", message="Ce champ doit etre unique")
 * @ApiResource(
 *     attributes={"pagination_items_per_page"=3},
 *     itemOperations={
 *      "get_user_profil":{
 *      "method":"get",
 *      "path":"/admin/profils/{id}",
 *      "normalization_context"={"groups":"id1:read"},
 *     },
 *     "put_user_profil":{
 *      "method":"put",
 *      "path":"/admin/profils/{id}",
 *      "normalization_context"={"groups":"profil_put:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN'))",
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
     *@Groups({"profil:read","id1:read","profil_put:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"profil:read","id1:read","profil_put:read"})
     *
     */
    private $libelle;



    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $archive;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="profil")
     */
    private $users;

    public function __construct()
    {
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


    public function getArchive(): ?int
    {
        return $this->archive;
    }

    public function setArchive(int $archive): self
    {
        $this->archive = $archive;

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
}
