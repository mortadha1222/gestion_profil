<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Reservations
 *
 * @ORM\Table(name="reservations", indexes={@ORM\Index(name="id_member", columns={"id_member"}), @ORM\Index(name="id_coach", columns={"id_coach"}), @ORM\Index(name="id_plaaning", columns={"id_planning"})})
 * @ORM\Entity
 */
class Reservations
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_reservation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReservation;

    /**
     * @var int
     *
     * @ORM\Column(name="id_planning", type="integer", nullable=false)
     * @Assert\NotBlank(message="Insert the planning id")
     */
    private $idPlanning;

    /**
     * @var int
     *
     * @ORM\Column(name="id_member", type="integer", nullable=false)
     * @Assert\NotBlank(message="Insert the member id")

     */
    private $idMember;

    /**
     * @var int
     *
     * @ORM\Column(name="id_coach", type="integer", nullable=false)
     * @Assert\NotBlank(message="Insert the coach id")
     */
    private $idCoach;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=64, nullable=false)
     * @Assert\NotBlank(message="Insert your email")
     */
    private $email;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_reservation", type="date", nullable=true)
     * @Assert\NotBlank(message="Insert the reservation date")
     */
    private $dateReservation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="etat", type="string", length=10, nullable=true)
     * @Assert\NotBlank(message="Insert the date reservation")

     */
    private $etat;

    /**
     * @return int
     */
    public function getIdReservation(): ?int
    {
        return $this->idReservation;
    }

    /**
     * @param int $idReservation
     */
    public function setIdReservation(int $idReservation): void
    {
        $this->idReservation = $idReservation;
    }

    /**
     * @return int
     */
    public function getIdPlanning(): ?int
    {
        return $this->idPlanning;
    }

    /**
     * @param int $idPlanning
     */
    public function setIdPlanning(int $idPlanning): void
    {
        $this->idPlanning = $idPlanning;
    }

    /**
     * @return int
     */
    public function getIdMember(): ?int
    {
        return $this->idMember;
    }

    /**
     * @param int $idMember
     */
    public function setIdMember(int $idMember): void
    {
        $this->idMember = $idMember;
    }

    /**
     * @return int
     */
    public function getIdCoach(): ?int
    {
        return $this->idCoach;
    }

    /**
     * @param int $idCoach
     */
    public function setIdCoach(int $idCoach): void
    {
        $this->idCoach = $idCoach;
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
     * @return \DateTime|null
     */
    public function getDateReservation(): ?\DateTime
    {
        return $this->dateReservation;
    }

    /**
     * @param \DateTime|null $dateReservation
     */
    public function setDateReservation(?\DateTime $dateReservation): void
    {
        $this->dateReservation = $dateReservation;
    }

    /**
     * @return string|null
     */
    public function getEtat(): ?string
    {
        return $this->etat;
    }

    /**
     * @param string|null $etat
     */
    public function setEtat(?string $etat): void
    {
        $this->etat = $etat;
    }


}
