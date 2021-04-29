<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * User
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{

    /**
     * @var int
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUser;

    /**
     * @Assert\NotBlank
     * @var string
     * @ORM\Column(name="username", type="string", length=20, nullable=false)
     * @Groups("users:read")
     */
    private $username;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="password", type="string", length=20, nullable=false)
     * @Groups("users:read")
     */
    private $password;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="first_name", type="string", length=50, nullable=false)
     * @Groups("users:read")
     */
    private $firstName;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="last_name", type="string", length=50, nullable=false)
     * @Groups("users:read")
     */
    private $lastName;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="adresse", type="string", length=60, nullable=false)
     * @Groups("users:read")
     */
    private $adresse;

    /**
     * @var int
     * @Assert\NotBlank
     * @ORM\Column(name="telephone", type="integer", nullable=false)
     * @Groups("users:read")
     */
    private $telephone;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     * @ORM\Column(name="email", type="string", length=60, nullable=false)
     * @Groups("users:read")
     */
    private $email;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="photo", type="string", length=400, nullable=false)
     * @Groups("users:read")
     */
    private $photo;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="role", type="string",length=100,nullable=false)
     * @Groups("users:read")
     */
    private $role;
    /**
     * @var null
     */
    private $plainPassword;
    private $salt;

    /**
     * User constructor.
     * @param int $idUser
     * @param string $username
     * @param string $password
     * @param string $firstName
     * @param string $lastName
     * @param string $adresse
     * @param int $telephone
     * @param string $email
     * @param string $photo
     * @param string $role
     */

    public function __construct()
    {

    }

    /**
     * @return int
     */
    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    /**
     * @param int $idUser
     */
    public function setIdUser(int $idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * @return string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }

    /**
     * @return int
     */
    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    /**
     * @param int $telephone
     */
    public function setTelephone(int $telephone): void
    {
        $this->telephone = $telephone;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     */
    public function setPhoto(string $photo): void
    {
        $this->photo = $photo;
    }

    /**
     * Get role
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string $role
     *
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }


    public function getRoles()
    {
     //   return array(‘ROLE_USER’);
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }
}
