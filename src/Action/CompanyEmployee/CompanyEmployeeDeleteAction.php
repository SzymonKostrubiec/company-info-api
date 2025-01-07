<?php

declare(strict_types=1);

namespace CompanyInfoApi\Action\CompanyEmployee;

use CompanyInfoApi\Entity\Company;
use CompanyInfoApi\Repository\CompanyRepository;
use CompanyInfoApi\Resolver\CompanyEmployeeResolver;
use Symfony\Component\HttpFoundation\Request;

final readonly class CompanyEmployeeDeleteAction
{
    public function __construct(
        private CompanyEmployeeResolver $companyEmployeeResolver,
        private CompanyRepository $companyRepository,
    )
    {
    }

    public function delete(Request $request): Company
    {
        $employee = $this->companyEmployeeResolver->resolveEmployeeForAdd($request);
        $company = $this->companyEmployeeResolver->resolveCompanyForAdd($request);

        $company->removeEmployee($employee);
        $this->companyRepository->save();

        return $company;

    }
}