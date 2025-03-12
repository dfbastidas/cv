<?php

namespace App\Entity;

use App\Repository\CvTemplateRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CvTemplateRepository::class)]
class CvTemplate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $html = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHtml(): ?string
    {
        return $this->html;
    }

    public function setHtml(string $html): static
    {
        $this->html = $html;

        return $this;
    }
}
