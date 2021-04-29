<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Planning
 *
 * @ORM\Table(name="planning", indexes={@ORM\Index(name="id_coach", columns={"id_coach"})})
 * @ORM\Entity
 */
class Planning
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_planning", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPlanning;

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
     * @ORM\Column(name="coach_name", type="string", length=32, nullable=false)
     * @Assert\NotBlank(message="Insert the coach name")
     */
    private $coachName;

    /**
     * @var string
     *
     * @ORM\Column(name="course", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Insert your course")
     */
    private $course;

    /**
     * @var string
     *
     * @ORM\Column(name="startLesson", type="string", length=32, nullable=false)
     * @Assert\NotBlank(message="Insert the start lesson")
     */
    private $startlesson;

    /**
     * @var string
     *
     * @ORM\Column(name="endLesson", type="string", length=32, nullable=false)
     * @Assert\NotBlank(message="Insert the end lesson")
     */
    private $endlesson;

    /**
     * @var int
     *
     * @ORM\Column(name="maxNbr", type="integer", nullable=false)
     * @Assert\NotBlank(message="Insert the max number")
     */
    private $maxnbr;

    /**
     * @var int|null
     *
     * @ORM\Column(name="nbrActuel", type="integer", nullable=true)
     * @Assert\NotBlank(message="Insert the actuel number")

     */
    private $nbractuel;

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
    public function getCoachName(): ?string
    {
        return $this->coachName;
    }

    /**
     * @param string $coachName
     */
    public function setCoachName(string $coachName): void
    {
        $this->coachName = $coachName;
    }

    /**
     * @return string
     */
    public function getCourse(): ?string
    {
        return $this->course;
    }

    /**
     * @param string $course
     */
    public function setCourse(string $course): void
    {
        $this->course = $course;
    }

    /**
     * @return string
     */
    public function getStartlesson(): ?string
    {
        return $this->startlesson;
    }

    /**
     * @param string $startlesson
     */
    public function setStartlesson(string $startlesson): void
    {
        $this->startlesson = $startlesson;
    }

    /**
     * @return string
     */
    public function getEndlesson(): ?string
    {
        return $this->endlesson;
    }

    /**
     * @param string $endlesson
     */
    public function setEndlesson(string $endlesson): void
    {
        $this->endlesson = $endlesson;
    }

    /**
     * @return int
     */
    public function getMaxnbr(): ?int
    {
        return $this->maxnbr;
    }

    /**
     * @param int $maxnbr
     */
    public function setMaxnbr(int $maxnbr): void
    {
        $this->maxnbr = $maxnbr;
    }

    /**
     * @return int|null
     */
    public function getNbractuel(): ?int
    {
        return $this->nbractuel;
    }

    /**
     * @param int|null $nbractuel
     */
    public function setNbractuel(?int $nbractuel): void
    {
        $this->nbractuel = $nbractuel;
    }


}
