<?php

namespace App\Entity;

use App\Repository\ContactHistoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: 'contactHistory', targetEntity: Contact::class)]
    private Collection $contactId;

    #[ORM\ManyToOne]
    private ?AdditionalField $additionalField = null;

    public function __construct()
    {
        $this->contactId = new ArrayCollection();
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

    /**
     * @return Collection<int, Contact>
     */
    public function getContactId(): Collection
    {
        return $this->contactId;
    }

    public function addContactId(Contact $contactId): static
    {
        if (!$this->contactId->contains($contactId)) {
            $this->contactId->add($contactId);
            $contactId->setContactHistory($this);
        }

        return $this;
    }

    public function removeContactId(Contact $contactId): static
    {
        if ($this->contactId->removeElement($contactId)) {
            // set the owning side to null (unless already changed)
            if ($contactId->getContactHistory() === $this) {
                $contactId->setContactHistory(null);
            }
        }

        return $this;
    }

    public function getAdditionalField(): ?AdditionalField
    {
        return $this->additionalField;
    }

    public function setAdditionalField(?AdditionalField $additionalField): static
    {
        $this->additionalField = $additionalField;

        return $this;
    }
}
