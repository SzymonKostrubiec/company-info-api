<?php

declare(strict_types=1);

namespace CompanyInfoApi\Entity;

use CompanyInfoApi\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('employee')]
    /* @phpstan-ignore-next-line - PHPStan  */
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('employee')]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups('employee')]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    #[Groups('employee')]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('employee')]
    private ?string $phone = null;

    /**
     * @var Collection<int, Company>
     */
    #[ORM\ManyToMany(targetEntity: Company::class, inversedBy: 'employees')]
    #[Groups('employee_company')]
    private Collection $company;

    public function __construct()
    {
        $this->company = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection<int, Company>
     */
    public function getCompany(): Collection
    {
        return $this->company;
    }

    public function addCompany(Company $company): static
    {
        if (!$this->company->contains($company)) {
            $this->company->add($company);
        }

        return $this;
    }

    public function removeCompany(Company $company): static
    {
        $this->company->removeElement($company);

        return $this;
    }
}
