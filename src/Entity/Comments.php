<?php

namespace App\Entity;

use App\Repository\CommentsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentsRepository::class)]
class Comments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Contenu = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbReactions = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Posts $Post = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->Contenu;
    }

    public function setContenu(?string $Contenu): self
    {
        $this->Contenu = $Contenu;

        return $this;
    }

    public function getNbReactions(): ?int
    {
        return $this->nbReactions;
    }

    public function setNbReactions(?int $nbReactions): self
    {
        $this->nbReactions = $nbReactions;

        return $this;
    }

    public function getPost(): ?Posts
    {
        return $this->Post;
    }

    public function setPost(?Posts $Post): self
    {
        $this->Post = $Post;

        return $this;
    }
}
