<?php

namespace CompanyInfoApi\Action\Employee;

use CompanyInfoApi\Dto\EmployeeDto;
use CompanyInfoApi\Entity\Employee;
use CompanyInfoApi\Repository\EmployeeRepository;
use CompanyInfoApi\Resolver\EmployeeResolver;

final readonly class CreateEmployeeAction
{
    public function __construct(
        private EmployeeResolver $employeeResolver,
        private EmployeeRepository $employeeRepository
    )
    {
    }

    public function create(EmployeeDto $employeeDto): Employee
    {
        $employee= $this->employeeResolver->resolveForCreate($employeeDto);
       $this->employeeRepository->add($employee);

       return $employee;
    }
}