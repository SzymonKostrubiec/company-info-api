<?php

declare(strict_types=1);

namespace CompanyInfoApi\Mapper;

use CompanyInfoApi\Dto\CompanyDto;
use CompanyInfoApi\Entity\Company;

final class CompanyMapper
{
    public function mapDtoToNewEntity(CompanyDto $dto): Company
    {
        $company = new Company();
        $this->mapFields($company, $dto);
        return $company;
    }

    public function mapDtoToExistingEntity(Company $company, CompanyDto $dto): void
    {
        $this->mapFields($company, $dto);
    }

    private function mapFields(Company $company, CompanyDto $dto): void
    {
        $company->setName($dto->name ?? '');
        $company->setNip($dto->nip ?? '');
        $company->setAddress($dto->address ?? '');
        $company->setCity($dto->city ?? '');
        $company->setPostalCode($dto->postalCode ?? '');
    }
}