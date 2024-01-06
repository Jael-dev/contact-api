<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $birthdate = null;

    #[ORM\Column]
    private ?bool $isFavorite = null;

    #[ORM\ManyToOne(inversedBy: 'contacts')]
    #[ORM\JoinColumn(name:"group_id_id", referencedColumnName:"id", nullable:true)]
    private ?Group $groupId;

    #[ORM\OneToMany(mappedBy: 'contact', targetEntity: AdditionalField::class, orphanRemoval: true)]
    private Collection $additionalFields;

    #[ORM\OneToMany(mappedBy: 'contact', targetEntity: ContactHistory::class, orphanRemoval: true)]
    private Collection $contactHistories;

    public function __construct()
    {
        $this->additionalFields = new ArrayCollection();
        $this->contactHistories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getBirthdate(): ?string
    {
        return $this->birthdate;
    }

    public function setBirthdate(?string $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function isIsFavorite(): ?bool
    {
        return $this->isFavorite;
    }

    public function setIsFavorite(bool $isFavorite): static
    {
        $this->isFavorite = $isFavorite;

        return $this;
    }

    public function getGroupId(): ?Group
    {
        return $this->groupId;
    }

    public function setGroupId(?Group $groupId): static
    {
        $this->groupId = $groupId;

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
            $additionalField->setContact($this);
        }

        return $this;
    }

    public function removeAdditionalField(AdditionalField $additionalField): static
    {
        if ($this->additionalFields->removeElement($additionalField)) {
            // set the owning side to null (unless already changed)
            if ($additionalField->getContact() === $this) {
                $additionalField->setContact(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ContactHistory>
     */
    public function getContactHistories(): Collection
    {
        return $this->contactHistories;
    }

    public function addContactHistory(ContactHistory $contactHistory): static
    {
        if (!$this->contactHistories->contains($contactHistory)) {
            $this->contactHistories->add($contactHistory);
            $contactHistory->setContact($this);
        }

        return $this;
    }

    public function removeContactHistory(ContactHistory $contactHistory): static
    {
        if ($this->contactHistories->removeElement($contactHistory)) {
            // set the owning side to null (unless already changed)
            if ($contactHistory->getContact() === $this) {
                $contactHistory->setContact(null);
            }
        }

        return $this;
    }
}
