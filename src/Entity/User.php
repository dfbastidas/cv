<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $last_name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $about_me = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $main_phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $second_phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $main_email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $second_email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    /**
     * @var Collection<int, CurriculumVitae>
     */
    #[ORM\OneToMany(targetEntity: CurriculumVitae::class, mappedBy: 'owner', orphanRemoval: true)]
    private Collection $curriculumVitaes;

    /**
     * @var Collection<int, Experience>
     */
    #[ORM\OneToMany(targetEntity: Experience::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $experience;

    /**
     * @var Collection<int, Education>
     */
    #[ORM\OneToMany(targetEntity: Education::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $education;

    /**
     * @var Collection<int, Link>
     */
    #[ORM\OneToMany(targetEntity: Link::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $links;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $main_profession = null;

    public function __construct()
    {
        $this->curriculumVitaes = new ArrayCollection();
        $this->experience = new ArrayCollection();
        $this->education = new ArrayCollection();
        $this->links = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getAboutMe(): ?string
    {
        return $this->about_me;
    }

    public function setAboutMe(?string $about_me): static
    {
        $this->about_me = $about_me;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getMainPhone(): ?string
    {
        return $this->main_phone;
    }

    public function setMainPhone(?string $main_phone): static
    {
        $this->main_phone = $main_phone;

        return $this;
    }

    public function getSecondPhone(): ?string
    {
        return $this->second_phone;
    }

    public function setSecondPhone(?string $second_phone): static
    {
        $this->second_phone = $second_phone;

        return $this;
    }

    public function getMainEmail(): ?string
    {
        return $this->main_email;
    }

    public function setMainEmail(?string $main_email): static
    {
        $this->main_email = $main_email;

        return $this;
    }

    public function getSecondEmail(): ?string
    {
        return $this->second_email;
    }

    public function setSecondEmail(?string $second_email): static
    {
        $this->second_email = $second_email;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @return Collection<int, CurriculumVitae>
     */
    public function getCurriculumVitaes(): Collection
    {
        return $this->curriculumVitaes;
    }

    public function addCurriculumVitae(CurriculumVitae $curriculumVitae): static
    {
        if (!$this->curriculumVitaes->contains($curriculumVitae)) {
            $this->curriculumVitaes->add($curriculumVitae);
            $curriculumVitae->setOwner($this);
        }

        return $this;
    }

    public function removeCurriculumVitae(CurriculumVitae $curriculumVitae): static
    {
        if ($this->curriculumVitaes->removeElement($curriculumVitae)) {
            // set the owning side to null (unless already changed)
            if ($curriculumVitae->getOwner() === $this) {
                $curriculumVitae->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Experience>
     */
    public function getExperience(): Collection
    {
        return $this->experience;
    }

    public function addExperience(Experience $experience): static
    {
        if (!$this->experience->contains($experience)) {
            $this->experience->add($experience);
            $experience->setUser($this);
        }

        return $this;
    }

    public function removeExperience(Experience $experience): static
    {
        if ($this->experience->removeElement($experience)) {
            // set the owning side to null (unless already changed)
            if ($experience->getUser() === $this) {
                $experience->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Education>
     */
    public function getEducation(): Collection
    {
        return $this->education;
    }

    public function addEducation(Education $education): static
    {
        if (!$this->education->contains($education)) {
            $this->education->add($education);
            $education->setUser($this);
        }

        return $this;
    }

    public function removeEducation(Education $education): static
    {
        if ($this->education->removeElement($education)) {
            // set the owning side to null (unless already changed)
            if ($education->getUser() === $this) {
                $education->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Link>
     */
    public function getLinks(): Collection
    {
        return $this->links;
    }

    public function addLink(Link $link): static
    {
        if (!$this->links->contains($link)) {
            $this->links->add($link);
            $link->setUser($this);
        }

        return $this;
    }

    public function removeLink(Link $link): static
    {
        if ($this->links->removeElement($link)) {
            // set the owning side to null (unless already changed)
            if ($link->getUser() === $this) {
                $link->setUser(null);
            }
        }

        return $this;
    }

    public function getMainProfession(): ?string
    {
        return $this->main_profession;
    }

    public function setMainProfession(?string $main_profession): static
    {
        $this->main_profession = $main_profession;

        return $this;
    }
}
