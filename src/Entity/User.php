<?php

namespace App\Entity;


use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 *  @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"admin"="Admin","apprenant"="Apprenant", "cm"="Cm" ,"formateur"="Formateur", "user"="User"})
 * @ApiFilter(SearchFilter::class, properties={"statut": "partial"})
 * @ApiResource(
 *     collectionOperations={
 *     "addUser":{
 *              "method":"POST",
 *              "route_name"="adding",
 *              "deserialize"=false,
 *              "access_control"="(is_granted('ROLE_ADMIN') )",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource",
 *               },
 *
 *      "get_users":{
 *              "method":"GET",
 *              "path":"/admin/users",
 *              "normalization_context"={"groups"="users:read"},
 *              "access_control"="(is_granted('ROLE_ADMIN') )",
 *              "access_control_message"="Vous n'étes pas autorisé à cette Ressource",
 *     },
 *
 *     },
 *
 *    itemOperations={
 *       "get_admin":{
 *              "method":"GET",
 *              "path":"/admin/users/{id}",
 *              "normalization_context"={"groups"="usersid:read"},
 *              "access_control"="(is_granted('ROLE_ADMIN') )",
 *              "access_control_message"="Vous n'étes pas autorisé à cette Ressource",
 *     },
 *     "updateUser"={
 *              "method"="put",
 *                
 *              "access_control"="(is_granted('ROLE_ADMIN') )",
 *              "deserialize"= false,
 *          },
 *    "delete_users":{
 *      "method"="DELETE",
 *      "path":"/admin/users/{id}",
 *      "normalization_context"={"groups":"profil_put:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN'))",
 *      "access_control_message"="Vous n'étes pas autorisé à cette ressource"
 *     }
 *     },
 *
 *
 *
 * )
 */
class User implements UserInterface
{
 public function __construct($statut=null)
    {
        $this->statut=true;
        $this->chats = new ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"id1:read","profil_put:read","groupeApp:read","users:read","groupe:read","groupes:write","usersid:read","profil_id:read"})
     *
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true,)
     * @Groups({"id1:read","profil_put:read","users:read","appnt_id:read","usersid:read"})
     *
     */
    private $username;


    private $roles = [];

    /**
     *@var string The hashed password
     * @ORM\Column(type="string")
     *
     *
     */
    private $password;


    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"users:read","groupe:read","appnt_id:read","usersid:read","profil_id:read"})
     *
     *
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"users:read","groupe:read","groupeApp:read","appnt_id:read","usersid:read","profil_id:read"})
     *
     *
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\Email(message="Email invalid")
     * @Groups({"users:read","groupe:read","appnt_id:read","usersid:read","profil_id:read"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"users:read","groupe:read","appnt_id:read","profil_id:read"})
     *
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"users:read","groupe:read","groupeApp:read","appnt_id:read","usersid:read","profil_id:read"})
     *
     */
    private $adresse;


    /**
     * @ORM\OneToMany(targetEntity=Chat::class, mappedBy="user")
     */
    private $chats;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="users")
     * @Groups({"users:read","groupe:read","groupeApp:read","appnt_id:read","usersid:read"})
     */
    private $profil;

    /**
     * @ORM\Column(type="blob", nullable=true)
     * @Groups({"users:read","groupe:read","groupeApp:read","appnt_id:read","usersid:read","profil_id:read"})
     */
    private $photo;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $statut;



    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_'.$this->profil->getLibelle();

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }



    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }


    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    /**
     * @return Collection|Chat[]
     */
    public function getChats(): Collection
    {
        return $this->chats;
    }

    public function addChat(Chat $chat): self
    {
        if (!$this->chats->contains($chat)) {
            $this->chats[] = $chat;
            $chat->setUser($this);
        }

        return $this;
    }

    public function removeChat(Chat $chat): self
    {
        if ($this->chats->removeElement($chat)) {
            // set the owning side to null (unless already changed)
            if ($chat->getUser() === $this) {
                $chat->setUser(null);
            }
        }

        return $this;
    }

    public function getPhoto()
    {
        if($this->photo !== null){
            return base64_encode(stream_get_contents($this->photo));
        }else
        {
            return $this->photo;
        }

        
    }

    public function setPhoto($photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(?bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }



}
