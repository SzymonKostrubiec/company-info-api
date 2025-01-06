<?php

declare(strict_types=1);

namespace CompanyInfoApi\Action\Employee;

use CompanyInfoApi\Entity\Employee;
use CompanyInfoApi\Repository\EmployeeRepository;
use CompanyInfoApi\Resolver\EmployeeResolver;
use Symfony\Component\HttpFoundation\Request;

final readonly class GetEmployeeAction
{
    public function __construct(
        private EmployeeResolver $employeeResolver,
        private EmployeeRepository $employeeRepository
    ){
    }

    /** @return Employee[] */
    public function list(): array
    {
        /** @var Employee[] $employees */
        $employees =  $this->employeeRepository->findAll();
        return $employees;
    }

    public function show(Request $request): Employee
    {
        return $this->employeeResolver->resolveByRequestId($request);
    }

}