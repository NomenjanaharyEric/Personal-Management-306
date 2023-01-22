<?php

namespace App\Entity;

use App\Repository\JobRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: JobRepository::class)]
class Job
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull()]
    #[Assert\Length(min: 4, max:255)]
    private ?string $title = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    #[Assert\Positive()]
    private ?float $baseSalary = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    #[Assert\Positive()]
    #[Assert\LessThan(576)]
    private ?int $workHours = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotNull()]
    #[Assert\Length(min: 10)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'jobs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Service $service = null;

    #[ORM\OneToMany(mappedBy: 'job', targetEntity: Employee::class, orphanRemoval: true)]
    private Collection $employees;

    public function __construct()
    {
        $this->employees = new ArrayCollection();
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

    public function getBaseSalary(): ?float
    {
        return $this->baseSalary;
    }

    public function setBaseSalary(float $baseSalary): self
    {
        $this->baseSalary = $baseSalary;

        return $this;
    }

    public function getWorkHours(): ?int
    {
        return $this->workHours;
    }

    public function setWorkHours(int $workHours): self
    {
        $this->workHours = $workHours;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @return Collection<int, Employee>
     */
    public function getEmployees(): Collection
    {
        return $this->employees;
    }

    public function addEmployee(Employee $employee): self
    {
        if (!$this->employees->contains($employee)) {
            $this->employees->add($employee);
            $employee->setJob($this);
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): self
    {
        if ($this->employees->removeElement($employee)) {
            // set the owning side to null (unless already changed)
            if ($employee->getJob() === $this) {
                $employee->setJob(null);
            }
        }

        return $this;
    }
}
