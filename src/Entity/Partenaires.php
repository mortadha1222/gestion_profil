<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Partenaires
 *
 * @ORM\Table(name="partenaires")
 * @ORM\Entity
 */
class Partenaires
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_partenaire", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPartenaire;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=20, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=1000, nullable=false)
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="site", type="string", length=1000, nullable=false)
     */
    private $site;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100, nullable=false)
     */
    private $description;

    /**
     * Partenaires constructor.
     */
    public function __construct()
    {
    }

    /**
     * Partenaires constructor.
     * @param int $idPartenaire
     * @param string $nom
     * @param string $photo
     * @param string $site
     * @param string $description
     */


    /**
     * @return int
     */
    public function getIdPartenaire(): ?int
    {
        return $this->idPartenaire;
    }

    /**
     * @param int $idPartenaire
     */
    public function setIdPartenaire(int $idPartenaire): void
    {
        $this->idPartenaire = $idPartenaire;
    }

    /**
     * @return string
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
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
     * @return string
     */
    public function getSite(): ?string
    {
        return $this->site;
    }

    /**
     * @param string $site
     */
    public function setSite(string $site): void
    {
        $this->site = $site;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }


}
