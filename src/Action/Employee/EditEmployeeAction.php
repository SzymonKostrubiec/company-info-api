<?php

namespace CompanyInfoApi\Action\Employee;

use CompanyInfoApi\Dto\EmployeeDto;
use CompanyInfoApi\Entity\Employee;
use CompanyInfoApi\Mapper\EmployeeMapper;
use CompanyInfoApi\Repository\EmployeeRepository;
use CompanyInfoApi\Resolver\EmployeeResolver;
use Symfony\Component\HttpFoundation\Request;

final readonly class EditEmployeeAction
{
    public function __construct(
        private EmployeeResolver $employeeResolver,
        private EmployeeRepository $employeeRepository,
        private EmployeeMapper $employeeMapper
    )
    {
    }

    public function edit(Request $request, EmployeeDto $employeeDto): Employee
    {
        $employee = $this->employeeResolver->resolveByRequestId($request);
        $this->employeeMapper->mapDtoToExistingEntity($employee, $employeeDto);
        $this->employeeRepository->save();

        return $employee;
    }

    public function patch(Request $request): Employee
    {
        $employee = $this->employeeResolver->resolveByRequestId($request);
        $this->fillEntityWithRequestData($employee, $request);
        $this->employeeRepository->save();

        return $employee;
    }

    private function fillEntityWithRequestData(Employee $employee, Request $request): void
    {
        $data = json_decode($request->getContent(), true);
        foreach ($data as $key => $value) {
            $employee->{'set' . ucfirst($key)}($value);
        }
    }
}