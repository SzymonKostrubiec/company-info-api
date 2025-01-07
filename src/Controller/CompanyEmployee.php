<?php

declare(strict_types=1);

namespace CompanyInfoApi\Controller;

use CompanyInfoApi\Action\CompanyEmployee\CompanyEmployeeAddAction;
use CompanyInfoApi\Action\CompanyEmployee\CompanyEmployeeDeleteAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[Route('/api/v1/company/{companyId}/employee/{employeeId}')]
final readonly class CompanyEmployee
{
    public function __construct(
        private  CompanyEmployeeAddAction $companyEmployeeAddAction, private CompanyEmployeeDeleteAction $companyEmployeeDropAction
    )
    {
    }

    #[Route( '', name: 'add-employee-to-company', methods: ['POST'])]
    #[OA\Post(
        operationId: 'add-employee-to-company',
        summary: 'Add employee to company',
        tags: ['Company Employee'],

    )]
    public function addEmployee(Request $request): JsonResponse {
        try{
            $this->companyEmployeeAddAction->add($request);
            return new JsonResponse(
                [
                    "message" => "Successfully added employee to company"
                ],
                Response::HTTP_CREATED
            );
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    #[Route( '', name: 'delete-employee-from-company', methods: ['DELETE'])]
    #[OA\Delete(
        operationId: 'delete-employee-from-company',
        summary: 'Drop employee from company',
        tags: ['Company Employee'],

    )]
    public function removeEmployee(Request $request): JsonResponse {
        try{
            $this->companyEmployeeDropAction->delete($request);
            return new JsonResponse(
                [
                    "message" => "Successfully removed employee from company"
                ],
                Response::HTTP_CREATED
            );
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
}