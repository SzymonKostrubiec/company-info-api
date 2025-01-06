<?php

namespace CompanyInfoApi\Action\Company;

use CompanyInfoApi\Repository\CompanyRepository;
use CompanyInfoApi\Resolver\CompanyResolver;
use Symfony\Component\HttpFoundation\Request;


final readonly class DeleteCompanyAction
{

    public function __construct(
        private CompanyResolver $companyResolver,
        private CompanyRepository $companyRepository
    ){
    }

    public function delete(Request $request): void
    {
        $company = $this->companyResolver->resolveByRequestId($request);
        $this->companyRepository->delete($company);

    }
}