<?php

namespace CompanyInfoApi\Action\Company;

use CompanyInfoApi\Dto\CompanyDto;
use CompanyInfoApi\Entity\Company;
use CompanyInfoApi\Mapper\CompanyMapper;
use CompanyInfoApi\Repository\CompanyRepository;
use CompanyInfoApi\Resolver\CompanyResolver;
use Symfony\Component\HttpFoundation\Request;

final readonly class EditCompanyAction
{
    public function __construct(
        private CompanyResolver $companyResolver,
        private CompanyRepository $companyRepository,
        private CompanyMapper $companyMapper
    )
    {
    }

    public function edit(Request $request, CompanyDto $companyDto): Company
    {
        $company = $this->companyResolver->resolveByRequestId($request);
        $this->companyMapper->mapDtoToExistingEntity($company, $companyDto);
        $this->companyRepository->save();

        return $company;
    }

    public function patch(Request $request): Company
    {
        $company = $this->companyResolver->resolveByRequestId($request);
        $this->fillEntityWithRequestData($company, $request);
        $this->companyRepository->save();

        return $company;
    }

    private function fillEntityWithRequestData(Company $company, Request $request): void
    {
        $data = json_decode($request->getContent(), true);
        foreach ($data as $key => $value) {
            $company->{'set' . ucfirst($key)}($value);
        }
    }
}