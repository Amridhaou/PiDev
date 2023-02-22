<?php

namespace App\Entity;

use App\Repository\CertificatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CertificatRepository::class)]
class Certificat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $Num_Certificat = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(
        message: 'Indiquez le nom du bénéficaire.'
    )]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(
        message: 'Indiquez l\'identifiant du bénéficaire.'
    )]
    private ?string $Identifiant = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\LessThanOrEqual(
        value: 'today',
        message: 'La date ne doit pas dépasser aujourdhui.'
    )]
    private ?\DateTimeInterface $Date_Examen = null;

    #[ORM\Column]
    private ?bool $Resultat = null;

    #[ORM\ManyToOne(inversedBy: 'certificats')]
    #[ORM\JoinColumn(name: 'cours_id',referencedColumnName: 'code_cours')]
    #[Assert\NotNull(
        message: 'Selectionnez un cours valide.'
    )]
    private ?Cours $Cours = null;


    public function getNumCertificat(): ?int
    {
        return $this->Num_Certificat;
    }

    public function setNumCertificat(int $Num_Certificat): self
    {
        $this->Num_Certificat = $Num_Certificat;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getIdentifiant(): ?string
    {
        return $this->Identifiant;
    }

    public function setIdentifiant(string $Identifiant): self
    {
        $this->Identifiant = $Identifiant;

        return $this;
    }

    public function getDateExamen(): ?\DateTimeInterface
    {
        return $this->Date_Examen;
    }

    public function setDateExamen(\DateTimeInterface $Date): self
    {
        $this->Date_Examen = $Date;

        return $this;
    }

    public function isResultat(): ?bool
    {
        return $this->Resultat;
    }

    public function setResultat(bool $Resultat): self
    {
        $this->Resultat = $Resultat;

        return $this;
    }

    public function getCours(): ?Cours
    {
        return $this->Cours;
    }

    public function setCours(?Cours $Cours): self
    {
        $this->Cours = $Cours;

        return $this;
    }
}
