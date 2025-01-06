<?php

declare(strict_types=1);

namespace CompanyInfoApi\Action\Company;

use CompanyInfoApi\Dto\CompanyDto;
use CompanyInfoApi\Entity\Company;
use CompanyInfoApi\Repository\CompanyRepository;
use CompanyInfoApi\Resolver\CompanyResolver;

final readonly class CreateCompanyAction
{
    public function __construct(
        private CompanyResolver $companyResolver,
        private CompanyRepository $companyRepository
    )
    {
    }

    public function create(CompanyDto $companyDto): Company
    {
       $company= $this->companyResolver->resolveForCreate($companyDto);
       $this->companyRepository->add($company);

       return $company;
    }
}