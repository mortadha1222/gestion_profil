<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Actualities
 *
 * @ORM\Table(name="actualities")
 * @ORM\Entity
 */
class Actualities
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_act", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAct;

    /**
     * @var string
     *
     * @ORM\Column(name="title_act", type="string", length=100, nullable=false)
     */
    private $titleAct;

    /**
     *
     *
     * @ORM\Column(name="date_act", type="date", nullable=false)
     */
    private $dateAct;

    /**
     * @var string
     *
     * @ORM\Column(name="description_act", type="string", length=100, nullable=false)
     */
    private $descriptionAct;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_act", type="string", length=100, nullable=false)
     */
    private $photoAct;

    /**
     * @var int
     *
     * @ORM\Column(name="id_member", type="integer", nullable=false)
     */
    private $idMember;

    /**
     * @return int
     */
    public function getIdAct(): ?int
    {
        return $this->idAct;
    }

    /**
     * @param int $idAct
     * @return Actualities
     */
    public function setIdAct(int $idAct): Actualities
    {
        $this->idAct = $idAct;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitleAct(): ?string
    {
        return $this->titleAct;
    }

    /**
     * @param string $titleAct
     * @return Actualities
     */
    public function setTitleAct(string $titleAct): Actualities
    {
        $this->titleAct = $titleAct;
        return $this;
    }


    public function getDateAct(): ?\DateTimeInterface
    {
        return $this->dateAct;
    }


    public function setDateAct(\DateTimeInterface $dateAct): Actualities
    {
        $this->dateAct = $dateAct;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescriptionAct(): ?string
    {
        return $this->descriptionAct;
    }

    /**
     * @param string $descriptionAct
     * @return Actualities
     */
    public function setDescriptionAct(string $descriptionAct): ?Actualities
    {
        $this->descriptionAct = $descriptionAct;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhotoAct(): ?string
    {
        return $this->photoAct;
    }

    /**
     * @param string $photoAct
     * @return Actualities
     */
    public function setPhotoAct(string $photoAct): Actualities
    {
        $this->photoAct = $photoAct;
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
     * @return Actualities
     */
    public function setIdMember(int $idMember): Actualities
    {
        $this->idMember = $idMember;
        return $this;
    }


}
