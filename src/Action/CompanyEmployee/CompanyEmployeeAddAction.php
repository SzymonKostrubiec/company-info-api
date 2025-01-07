<?php

declare(strict_types=1);

namespace CompanyInfoApi\Action\CompanyEmployee;

use CompanyInfoApi\Entity\Company;
use CompanyInfoApi\Repository\CompanyRepository;
use CompanyInfoApi\Resolver\CompanyEmployeeResolver;
use Symfony\Component\HttpFoundation\Request;

final readonly class CompanyEmployeeAddAction
{
    public function __construct(
        private CompanyEmployeeResolver $companyEmployeeResolver,
        private CompanyRepository $companyRepository,
    )
    {
    }

    public function add(Request $request): Company
    {
        $employee = $this->companyEmployeeResolver->resolveEmployeeForAdd($request);
        $company = $this->companyEmployeeResolver->resolveCompanyForAdd($request);

        $company->addEmployee($employee);
        $this->companyRepository->save();

        return $company;

    }
}