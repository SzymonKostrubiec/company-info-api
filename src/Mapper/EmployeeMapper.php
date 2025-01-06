<?php

namespace CompanyInfoApi\Mapper;

use CompanyInfoApi\Dto\EmployeeDto;
use CompanyInfoApi\Entity\Employee;

final class EmployeeMapper
{
    public function mapDtoToNewEntity(EmployeeDto $dto): Employee
    {
        $employee = new Employee();
        $this->mapFields($employee, $dto);
        return $employee;
    }

    public function mapDtoToExistingEntity(Employee $employee, EmployeeDto $dto): void
    {
        $this->mapFields($employee, $dto);
    }

    private function mapFields(Employee $employee, EmployeeDto $dto): void
    {
        $employee->setName($dto->name ?? '');
        $employee->setLastName($dto->lastName ?? '');
        $employee->setEmail($dto->email ?? '');
        $employee->setPhone($dto->phone);
    }
}