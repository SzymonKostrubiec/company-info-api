<?php

namespace CompanyInfoApi\Controller;

use CompanyInfoApi\Action\Company\CreateCompanyAction;
use CompanyInfoApi\Action\Company\DeleteCompanyAction;
use CompanyInfoApi\Action\Company\EditCompanyAction;
use CompanyInfoApi\Action\Company\GetCompanyAction;
use CompanyInfoApi\Dto\CompanyDto;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/v1/company')]
final readonly class CompanyController
{
    public function __construct(
        private CreateCompanyAction $createCompanyAction,
        private GetCompanyAction $getCompanyAction,
        private EditCompanyAction $editCompanyAction,
        private DeleteCompanyAction $deleteCompanyAction,
        private SerializerInterface $serializer
    )
    {
    }

    #[Route( '', name: 'create-new-company', methods: ['POST'])]
    #[OA\Post(
        operationId: 'create-new-company',
        summary: 'Creates a new company',
        tags: ['Company'],

    )]
    #[OA\RequestBody(
        content: [
            new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(properties: [
                    new OA\Property(
                        property: 'name',
                        type: 'string',
                        example: 'F.H.U XYZ POL '
                    ),
                    new OA\Property(
                        property: 'nip',
                        type: 'string',
                        example: '1234567890'
                    ),
                    new OA\Property(
                        property: 'address',
                        type: 'string',
                        example: 'Ul. XYZ 12'
                    ),
                    new OA\Property(
                        property: 'city',
                        type: 'string',
                        example: 'Wrocław'
                    ),
                    new OA\Property(
                        property: 'postalCode',
                        type: 'string',
                        example: '50-123'
                    ),
                ])
            ),
        ]
    )]
    public function store(#[MapRequestPayload] CompanyDto $companyDto): JsonResponse
    {
        try{
            $company = $this->createCompanyAction->create($companyDto);

            return new JsonResponse(
                [
                    "message" => "Company created",
                    "id" => $company->getId()
                ],
                Response::HTTP_CREATED
            );
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    #[Route( '', name: 'get-companies', methods: ['GET'])]
    #[OA\Get(
        operationId: 'get-all-companies',
        summary: 'Get all companies',
        tags: ['Company'],

    )]
    public function index(): JsonResponse
    {
        try {
            $companies =  $this->getCompanyAction->list();

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

    #[Route( '/{id}', name: 'get-one-company', methods: ['GET'])]
    #[OA\Get(
        operationId: 'get-one-company-by-id',
        summary: 'Get one company by id',
        tags: ['Company'],

    )]
    public function show(Request $request): JsonResponse
    {
        try {
            $company = $this->getCompanyAction->show($request);

            return new JsonResponse(
                $this->serializer->serialize($company, 'json'),
                Response::HTTP_OK,
                [],
                true
            );

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    #[Route( '/{id}', name: 'partially-edit-exists-company', methods: ['PATCH'])]
    #[OA\Patch(
        operationId: 'partially-edit-exists-company',
        summary: 'Edit a some info on exists company',
        tags: ['Company'],
    )]
    #[OA\Put(
        operationId: 'edit-exists-company',
        summary: 'Edit exists company',
        tags: ['Company'],
    )]
    #[OA\RequestBody(
        content: [
            new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(properties: [
                    new OA\Property(
                        property: 'name',
                        type: 'string',
                        example: 'F.H.U XYZ POL '
                    ),
                    new OA\Property(
                        property: 'nip',
                        type: 'string',
                        example: '1234567890'
                    ),
                    new OA\Property(
                        property: 'address',
                        type: 'string',
                        example: 'Ul. XYZ 12'
                    ),
                    new OA\Property(
                        property: 'city',
                        type: 'string',
                        example: 'Wrocław'
                    ),
                    new OA\Property(
                        property: 'postalCode',
                        type: 'string',
                        example: '50-123'
                    ),
                ])
            ),
        ]
    )]
    public function update(Request $request): JsonResponse
    {
        try{
            $company = $this->editCompanyAction->patch($request);

            return new JsonResponse(
                [
                    "message" => "Company successfully edited",
                    "id" => $company->getId()
                ],
                Response::HTTP_CREATED
            );
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    #[Route( '/{id}', name: 'edit-exists-company', methods: ['PUT'])]
    #[OA\Put(
        operationId: 'edit-exists-company',
        summary: 'Edit exists company',
        tags: ['Company'],
    )]
    #[OA\RequestBody(
        content: [
            new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(properties: [
                    new OA\Property(
                        property: 'name',
                        type: 'string',
                        example: 'F.H.U XYZ POL '
                    ),
                    new OA\Property(
                        property: 'nip',
                        type: 'string',
                        example: '1234567890'
                    ),
                    new OA\Property(
                        property: 'address',
                        type: 'string',
                        example: 'Ul. XYZ 12'
                    ),
                    new OA\Property(
                        property: 'city',
                        type: 'string',
                        example: 'Wrocław'
                    ),
                    new OA\Property(
                        property: 'postalCode',
                        type: 'string',
                        example: '50-123'
                    ),
                ])
            ),
        ]
    )]
    public function edit(Request $request, #[MapRequestPayload] CompanyDto $companyDto ): JsonResponse
    {
        try{
            $company = $this->editCompanyAction->edit($request, $companyDto);

            return new JsonResponse(
                [
                    "message" => "Company successfully edited",
                    "id" => $company->getId()
                ],
                Response::HTTP_CREATED
            );
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    #[Route( '/{id}', name: 'delete-company', methods: ['DELETE'])]
    #[OA\Delete(
        operationId: 'delete-company',
        summary: 'Delete company',
        tags: ['Company'],

    )]
    public function destroy(Request $request): JsonResponse
    {
        try {
            $this->deleteCompanyAction->delete($request);

            return new JsonResponse(
                [
                    "message" => "Company successfully removed",
                ],
                Response::HTTP_OK
            );

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}