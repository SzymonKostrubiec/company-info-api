<?php

namespace CompanyInfoApi\Action\Employee;

use CompanyInfoApi\Repository\EmployeeRepository;
use CompanyInfoApi\Resolver\EmployeeResolver;
use Symfony\Component\HttpFoundation\Request;


final readonly class DeleteEmployeeAction
{

    public function __construct(
        private EmployeeResolver $employeeResolver,
        private EmployeeRepository $employeeRepository
    ){
    }

    public function delete(Request $request): void
    {
        $employee = $this->employeeResolver->resolveByRequestId($request);
        $this->employeeRepository->delete($employee);

    }
}