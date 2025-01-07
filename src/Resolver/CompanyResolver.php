<?php

declare(strict_types=1);

namespace CompanyInfoApi\Resolver;

use CompanyInfoApi\Dto\CompanyDto;
use CompanyInfoApi\Entity\Company;
use CompanyInfoApi\Mapper\CompanyMapper;
use CompanyInfoApi\Repository\CompanyRepository;
use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\Assert;

final readonly class CompanyResolver
{
    public function __construct(
        private CompanyRepository $companyRepository,
        private CompanyMapper $companyMapper
    )
    {
    }

    public function resolveForCreate( CompanyDto $companyDto): Company
    {
        /** @var string $nip */
        $nip = $companyDto->nip;
        Assert::null($this->existsCompanyWithNip($nip), 'Company with this NIP already exists');

        return $this->companyMapper->mapDtoToNewEntity($companyDto);
    }

    public function resolveByRequestId( Request $request): Company
    {
        $companyId = $request->get('id');
        Assert::notNull($companyId, 'Company ID is required');

        $company = $this->companyRepository->find($companyId);
        Assert::isInstanceOf($company, Company::class, 'Company not found');

        return $company;
    }

    private function existsCompanyWithNip(string $nip): ?Company
    {
        return $this->companyRepository->findOneBy(['nip' => $nip]);
    }
}