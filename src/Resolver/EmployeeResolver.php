<?php

namespace CompanyInfoApi\Resolver;

use CompanyInfoApi\Dto\EmployeeDto;
use CompanyInfoApi\Entity\Employee;
use CompanyInfoApi\Mapper\EmployeeMapper;
use CompanyInfoApi\Repository\EmployeeRepository;
use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\Assert;

final readonly class EmployeeResolver
{
    public function __construct(
        private EmployeeRepository $employeeRepository,
        private EmployeeMapper $employeeMapper
    )
    {
    }

    public function resolveForCreate( EmployeeDto $employeeDto): Employee
    {
        /** @var string $email */
        $email = $employeeDto->email;
        Assert::null($this->existsEmployeeWithEmail($email), 'Employee with this email already exists');
        return $this->employeeMapper->mapDtoToNewEntity($employeeDto);
    }

    public function resolveByRequestId( Request $request): Employee
    {
        $employeeId = $request->get('id');
        Assert::notNull($employeeId, 'Employee ID is required');

        $employee = $this->employeeRepository->find($employeeId);
        Assert::isInstanceOf($employee, Employee::class, 'Employee not found');

        return $employee;
    }

    private function existsEmployeeWithEmail(string $email): ?Employee
    {
        return $this->employeeRepository->findOneBy(['email' => $email]);
    }
}