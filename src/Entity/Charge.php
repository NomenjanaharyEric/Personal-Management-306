<?php

namespace App\Entity;

use App\Repository\ChargeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity("title")]
#[ORM\Entity(repositoryClass: ChargeRepository::class)]
class Charge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull()]
    #[Assert\Length(min: 3, max:255)]
    private ?string $title = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    #[Assert\Positive()]
    private ?float $partSalarial = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    #[Assert\Positive()]
    private ?float $employerContribution = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotNull()]
    #[Assert\Length(min:10)]
    private ?string $avantages = null;

    #[ORM\ManyToMany(targetEntity: Contract::class, inversedBy: 'charges')]
    private Collection $contracts;

    public function __construct()
    {
        $this->contracts = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function __toString(): String
    {
        return $this->getTitle();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPartSalarial(): ?float
    {
        return $this->partSalarial;
    }

    public function setPartSalarial(float $partSalarial): self
    {
        $this->partSalarial = $partSalarial;

        return $this;
    }

    public function getEmployerContribution(): ?float
    {
        return $this->employerContribution;
    }

    public function setEmployerContribution(float $employerContribution): self
    {
        $this->employerContribution = $employerContribution;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getAvantages(): ?string
    {
        return $this->avantages;
    }

    public function setAvantages(string $avantages): self
    {
        $this->avantages = $avantages;

        return $this;
    }

    /**
     * @return Collection<int, Contract>
     */
    public function getContracts(): Collection
    {
        return $this->contracts;
    }

    public function addContract(Contract $contract): self
    {
        if (!$this->contracts->contains($contract)) {
            $this->contracts->add($contract);
        }

        return $this;
    }

    public function removeContract(Contract $contract): self
    {
        $this->contracts->removeElement($contract);

        return $this;
    }
}
