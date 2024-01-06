<?php

namespace App\Entity;

use App\Repository\ContactHistoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactHistoryRepository::class)]
class ContactHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $operationName = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $timestamp = null;

    #[ORM\ManyToOne(inversedBy: 'contactHistories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Contact $contact = null;

    #[ORM\OneToMany(mappedBy: 'contactHistory', targetEntity: AdditionalField::class)]
    private Collection $additionalFields;

    public function __construct()
    {
        $this->additionalFields = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOperationName(): ?string
    {
        return $this->operationName;
    }

    public function setOperationName(string $operationName): static
    {
        $this->operationName = $operationName;

        return $this;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): static
    {
        $this->timestamp = $timestamp;

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

    /**
     * @return Collection<int, AdditionalField>
     */
    public function getAdditionalFields(): Collection
    {
        return $this->additionalFields;
    }

    public function addAdditionalField(AdditionalField $additionalField): static
    {
        if (!$this->additionalFields->contains($additionalField)) {
            $this->additionalFields->add($additionalField);
            $additionalField->setContactHistory($this);
        }

        return $this;
    }

    public function removeAdditionalField(AdditionalField $additionalField): static
    {
        if ($this->additionalFields->removeElement($additionalField)) {
            // set the owning side to null (unless already changed)
            if ($additionalField->getContactHistory() === $this) {
                $additionalField->setContactHistory(null);
            }
        }

        return $this;
    }
}
