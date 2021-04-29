<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Events
 *
 * @ORM\Table(name="events")
 * @ORM\Entity
 */
class Events
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_event", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     */
    private $idEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="name_eve", type="string", length=100, nullable=false)
     * @Assert\NotBlank(message="name is required")
     */
    private $nameEve;

    /**
     *
     *
     * @ORM\Column(name="date_eve", type="date", length=50, nullable=false)
     * @Assert\NotBlank(message="date is required")
     */
    private $dateEve;

    /**
     * @var string
     *
     * @ORM\Column(name="description_eve", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="description is required")
     */
    private $descriptionEve;

    /**
     *
     *
     * @ORM\Column(name="photo_eve", type="string", length=100, nullable=false)
     */
    private $photoEve;

    /**
     * @var int
     *
     * @ORM\Column(name="id_member", type="integer", nullable=false)
     * @Assert\NotBlank(message="field empty")
     */
    private $idMember;

    /**
     * @return string
     */
    public function getNameEve(): ?string
    {
        return $this->nameEve;
    }

    /**
     * @param string $nameEve
     * @return Events
     */
    public function setNameEve(string $nameEve): Events
    {
        $this->nameEve = $nameEve;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdEvent(): ?int
    {
        return $this->idEvent;
    }

    /**
     * @param int $idEvent
     * @return Events
     */
    public function setIdEvent(int $idEvent): Events
    {
        $this->idEvent = $idEvent;
        return $this;
    }



    public function getDateEve(): ?\DateTimeInterface
    {
        return $this->dateEve;
    }

    public function setDateEve(\DateTimeInterface $dateEve): self
    {
        $this->dateEve = $dateEve;

        return $this;
    }



    /**
     * @return string
     */
    public function getDescriptionEve(): ?string
    {
        return $this->descriptionEve;
    }

    /**
     * @param string $descriptionEve
     * @return Events
     */
    public function setDescriptionEve(string $descriptionEve): Events
    {
        $this->descriptionEve = $descriptionEve;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhotoEve(): ?string
    {
        return $this->photoEve;
    }

    /**
     * @param string $photoEve
     * @return Events
     */
    public function setPhotoEve(string $photoEve): Events
    {
        $this->photoEve = $photoEve;
        return $this;
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
     * @return Events
     */
    public function setIdMember(int $idMember): Events
    {
        $this->idMember = $idMember;
        return $this;
    }


}
