<?php

namespace CompanyInfoApi\Controller;

use CompanyInfoApi\Action\Employee\CreateEmployeeAction;
use CompanyInfoApi\Action\Employee\DeleteEmployeeAction;
use CompanyInfoApi\Action\Employee\EditEmployeeAction;
use CompanyInfoApi\Action\Employee\GetEmployeeAction;
use CompanyInfoApi\Dto\EmployeeDto;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/v1/employee')]
final readonly class EmployeeController
{
    public function __construct(
        private CreateEmployeeAction $createEmployeeAction,
        private GetEmployeeAction $getEmployeeAction,
        private EditEmployeeAction $editEmployeeAction,
        private DeleteEmployeeAction $deleteEmployeeAction,
        private SerializerInterface $serializer
    )
    {
    }

    #[Route( '', name: 'create-new-employee', methods: ['POST'])]
    #[OA\Post(
        operationId: 'create-new-employee',
        summary: 'Creates a new employee',
        tags: ['Employee'],

    )]
    #[OA\RequestBody(
        content: [
            new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(properties: [
                    new OA\Property(
                        property: 'name',
                        type: 'string',
                        example: 'Johny'
                    ),
                    new OA\Property(
                        property: 'lastName',
                        type: 'string',
                        example: 'Bravo'
                    ),
                    new OA\Property(
                        property: 'email',
                        type: 'string',
                        example: 'jb@jb.jb'
                    ),
                    new OA\Property(
                        property: 'phone',
                        type: 'string',
                        example: ''
                    ),
                ])
            ),
        ]
    )]
    public function store(#[MapRequestPayload] EmployeeDto $employeeDto): JsonResponse
    {
        try{
            $employee = $this->createEmployeeAction->create($employeeDto);

            return new JsonResponse(
                [
                    "message" => "Employee created",
                    "id" => $employee->getId()
                ],
                Response::HTTP_CREATED
            );
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    #[Route( '', name: 'get-employees', methods: ['GET'])]
    #[OA\Get(
        operationId: 'get-all-employees',
        summary: 'Get all employees',
        tags: ['Employee'],

    )]
    public function index(): JsonResponse
    {
        try {
            $companies =  $this->getEmployeeAction->list();

            return new JsonResponse(
                $this->serializer->serialize($companies, 'json'),
                Response::HTTP_OK,
                [],
                true
            );
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    #[Route( '/{id}', name: 'get-one-employee', methods: ['GET'])]
    #[OA\Get(
        operationId: 'get-one-employee-by-id',
        summary: 'Get one employee by id',
        tags: ['Employee'],

    )]
    public function show(Request $request): JsonResponse
    {
        try {
            $employee = $this->getEmployeeAction->show($request);

            return new JsonResponse(
                $this->serializer->serialize($employee, 'json'),
                Response::HTTP_OK,
                [],
                true
            );

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    #[Route( '/{id}', name: 'partially-edit-exists-employee', methods: ['PATCH'])]
    #[OA\Patch(
        operationId: 'partially-edit-exists-employee',
        summary: 'Edit a some info on exists employee',
        tags: ['Employee'],
    )]
    #[OA\RequestBody(
        content: [
            new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(properties: [
                    new OA\Property(
                        property: 'name',
                        type: 'string',
                        example: 'Johny'
                    ),
                    new OA\Property(
                        property: 'lastName',
                        type: 'string',
                        example: 'Bravo'
                    ),
                    new OA\Property(
                        property: 'email',
                        type: 'string',
                        example: 'jb@jb.jb'
                    ),
                    new OA\Property(
                        property: 'phone',
                        type: 'string',
                        example: ''
                    ),
                ])
            ),
        ]
    )]
    public function update(Request $request): JsonResponse
    {
        try{
            $employee = $this->editEmployeeAction->patch($request);

            return new JsonResponse(
                [
                    "message" => "Employee successfully edited",
                    "id" => $employee->getId()
                ],
                Response::HTTP_CREATED
            );
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    #[Route( '/{id}', name: 'edit-exists-employee', methods: ['PUT'])]
    #[OA\Put(
        operationId: 'edit-exists-employee',
        summary: 'Edit exists employee',
        tags: ['Employee'],
    )]
    #[OA\RequestBody(
        content: [
            new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(properties: [
                    new OA\Property(
                        property: 'name',
                        type: 'string',
                        example: 'Johny'
                    ),
                    new OA\Property(
                        property: 'lastName',
                        type: 'string',
                        example: 'Bravo'
                    ),
                    new OA\Property(
                        property: 'email',
                        type: 'string',
                        example: 'jb@jb.jb'
                    ),
                    new OA\Property(
                        property: 'phone',
                        type: 'string',
                        example: ''
                    ),
                ])
            ),
        ]
    )]
    public function edit(Request $request, #[MapRequestPayload] EmployeeDto $employeeDto ): JsonResponse
    {
        try{
            $employee = $this->editEmployeeAction->edit($request, $employeeDto);

            return new JsonResponse(
                [
                    "message" => "Employee successfully edited",
                    "id" => $employee->getId()
                ],
                Response::HTTP_CREATED
            );
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    #[Route( '/{id}', name: 'delete-employee', methods: ['DELETE'])]
    #[OA\Delete(
        operationId: 'delete-employee',
        summary: 'Delete employee',
        tags: ['Employee'],

    )]
    public function destroy(Request $request): JsonResponse
    {
        try {
            $this->deleteEmployeeAction->delete($request);

            return new JsonResponse(
                [
                    "message" => "Employee successfully removed",
                ],
                Response::HTTP_OK
            );

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}