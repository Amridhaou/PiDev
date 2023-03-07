<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
#[Vich\Uploadable]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $CodeCours = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(
        message: 'Indiquez un titre du cours.'
    )]
    private ?string $Nomination = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Support = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Positive(
        message: 'La durée doit être un entier positif.'
    )]
    private ?int $Duree = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Matiere = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Sujet = null;

    #[ORM\Column(nullable: true)]
    private ?int $ParticipantsNb = 0;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\GreaterThanOrEqual(
        value: 'today',
        message: 'La date doit être supérieure à aujourdhui.'
    )]
    private ?\DateTimeInterface $DatePublication = null;

    #[ORM\Column(length: 255)]
    private ?string $Tuteur = null;

    #[ORM\Column(length: 255)]
    private ?string $Contact = null;

    #[ORM\OneToMany(mappedBy: 'Cours', targetEntity: Certificat::class)]
    private Collection $certificats;


    #[Vich\UploadableField(mapping: 'video', fileNameProperty: 'Support')]
    #[Assert\File(
        maxSize: "8M",
        mimeTypes: "video/mp4",
        maxSizeMessage: "max 8M"
    )]
    private ?File $fileSupport = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    public function __construct()
    {
        $this->certificats = new ArrayCollection();
    }

    public function getCodeCours(): ?int
    {
        return $this->CodeCours;
    }

    public function setCodeCours(int $CodeCours): self
    {
        $this->CodeCours = $CodeCours;

        return $this;
    }

    public function getNomination(): ?string
    {
        return $this->Nomination;
    }

    public function setNomination(string $Nomination): self
    {
        $this->Nomination = $Nomination;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(?string $Type): self
    {
        $this->Type = $Type;

        return $this;
    }

    public function getSupport(): ?string
    {
        return $this->Support;
    }

    public function setSupport(?string $Support): self
    {
        $this->Support = $Support;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->Duree;
    }

    public function setDuree(?int $Duree): self
    {
        $this->Duree = $Duree;

        return $this;
    }

    public function getMatiere(): ?string
    {
        return $this->Matiere;
    }

    public function setMatiere(?string $Matiere): self
    {
        $this->Matiere = $Matiere;

        return $this;
    }

    public function getSujet(): ?string
    {
        return $this->Sujet;
    }

    public function setSujet(?string $Sujet): self
    {
        $this->Sujet = $Sujet;

        return $this;
    }

    public function getParticipantsNb(): ?int
    {
        return $this->ParticipantsNb;
    }

    public function setParticipantsNb(?int $ParticipantsNb): self
    {
        $this->ParticipantsNb = $ParticipantsNb;

        return $this;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->DatePublication;
    }

    public function setDatePublication(\DateTimeInterface $DatePublication): self
    {
        $this->DatePublication = $DatePublication;

        return $this;
    }

    public function getTuteur(): ?string
    {
        return $this->Tuteur;
    }

    public function setTuteur(string $Tuteur): self
    {
        $this->Tuteur = $Tuteur;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->Contact;
    }

    public function setContact(string $Contact): self
    {
        $this->Contact = $Contact;

        return $this;
    }

    /**
     * @return Collection<int, Certificat>
     */
    public function getCertificats(): Collection
    {
        return $this->certificats;
    }

    public function addCertificat(Certificat $certificat): self
    {
        if (!$this->certificats->contains($certificat)) {
            $this->certificats->add($certificat);
            $certificat->setCours($this);
        }

        return $this;
    }

    public function removeCertificat(Certificat $certificat): self
    {
        if ($this->certificats->removeElement($certificat)) {
            // set the owning side to null (unless already changed)
            if ($certificat->getCours() === $this) {
                $certificat->setCours(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getNomination();
    }

    public function getFileSupport(): ?File
    {
        return $this->fileSupport;
    }

    public function setFileSupport(File $fileSupport): void
    {
        $this->fileSupport = $fileSupport;
        if (null !== $fileSupport) {
            $this->updated_at = new \DateTimeImmutable('now');
        }
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

}
