<?php

declare(strict_types=1);

namespace CompanyInfoApi\Repository;

use CompanyInfoApi\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Employee>
 */
class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    public function save(): void
    {
        $this->getEntityManager()->flush();
    }

    public function add(Employee $employee): void
    {
        $this->getEntityManager()->persist($employee);
        $this->save();
    }

    public function delete(Employee $employee): void
    {
        $this->getEntityManager()->remove($employee);
        $this->save();
    }
}
