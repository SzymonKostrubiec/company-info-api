<?php

declare(strict_types=1);

namespace CompanyInfoApi\Repository;

use CompanyInfoApi\Entity\Company;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Company>
 */
class CompanyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }

    public function save(): void
    {
        $this->getEntityManager()->flush();
    }

    public function add(Company $company): void
    {
        $this->getEntityManager()->persist($company);
        $this->save();
    }

    public function delete(Company $company): void
    {
        $this->getEntityManager()->remove($company);
        $this->save();
    }

}
