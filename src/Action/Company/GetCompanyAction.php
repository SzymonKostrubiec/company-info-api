<?php

namespace CompanyInfoApi\Action\Company;

use CompanyInfoApi\Entity\Company;
use CompanyInfoApi\Repository\CompanyRepository;
use CompanyInfoApi\Resolver\CompanyResolver;
use Symfony\Component\HttpFoundation\Request;

final readonly class GetCompanyAction
{
    public function __construct(
        private CompanyResolver $companyResolver,
        private CompanyRepository $companyRepository,
    ){
    }

    /** @return Company[] */
    public function list(): array
    {
        /** @var Company[] $companies */
        $companies =  $this->companyRepository->findAll();
        return $companies;
    }

    public function show(Request $request): Company
    {
        return $this->companyResolver->resolveByRequestId($request);
    }

}