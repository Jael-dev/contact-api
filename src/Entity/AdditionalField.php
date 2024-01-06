<?php

namespace App\Entity;

use App\Repository\AdditionalFieldRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdditionalFieldRepository::class)]
class AdditionalField
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $fieldName = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $fieldValue = null;

    #[ORM\ManyToOne(inversedBy: 'additionalFields')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Contact $contact = null;

    #[ORM\ManyToOne(inversedBy: 'additionalFields')]
    private ?ContactHistory $contactHistory = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFieldName(): ?string
    {
        return $this->fieldName;
    }

    public function setFieldName(string $fieldName): static
    {
        $this->fieldName = $fieldName;

        return $this;
    }

    public function getFieldValue(): ?string
    {
        return $this->fieldValue;
    }

    public function setFieldValue(string $fieldValue): static
    {
        $this->fieldValue = $fieldValue;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    public function getContactHistory(): ?ContactHistory
    {
        return $this->contactHistory;
    }

    public function setContactHistory(?ContactHistory $contactHistory): static
    {
        $this->contactHistory = $contactHistory;

        return $this;
    }
}
