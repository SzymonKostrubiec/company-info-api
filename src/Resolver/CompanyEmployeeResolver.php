<?php

namespace CompanyInfoApi\Resolver;

use CompanyInfoApi\Entity\Company;
use CompanyInfoApi\Entity\Employee;
use CompanyInfoApi\Repository\CompanyRepository;
use CompanyInfoApi\Repository\EmployeeRepository;
use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\Assert;

final readonly class CompanyEmployeeResolver
{
    public function __construct(
        private EmployeeRepository $employeeRepository,
        private CompanyRepository $companyRepository
    ){
    }

    public function resolveEmployeeForAdd(Request $request): Employee
    {
        $employeeId = $request->get('employeeId');
        Assert::notNull($employeeId, 'Employee ID is required');
        $employee = $this->employeeRepository->find($employeeId);
        Assert::isInstanceOf($employee, Employee::class, 'Employee not found');
        return $employee;
    }

    public function resolveCompanyForAdd(Request $request): Company
    {
        $companyId = $request->get('companyId');
        Assert::notNull($companyId, 'Company ID is required');
        $company = $this->companyRepository->find($companyId);
        Assert::isInstanceOf($company, Company::class, 'Company not found');
        return $company;
    }
}