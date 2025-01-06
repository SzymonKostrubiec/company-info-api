<?php

declare(strict_types=1);

namespace CompanyInfoApi\Dto;

use CompanyInfoApi\Enum\CompanyDtoLengthEnum;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class CompanyDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(
            min: CompanyDtoLengthEnum::MIN_LENGTH->value,
            minMessage: 'Your company name must be at least {{ limit }} characters long',
        )]
        #[Assert\Type('string')]
        public ?string $name,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Length(
          min: CompanyDtoLengthEnum::NIP_MIN_LENGTH->value,
          max: CompanyDtoLengthEnum::NIP_MAX_LENGTH->value,
          minMessage: 'Your company NIP number must be at least {{ limit }} characters long',
          maxMessage: 'Your company NIP number must be at most {{ limit }} characters long'
        )]
        public ?string $nip,

        #[Assert\NotBlank]
        #[Assert\Length(
            min: CompanyDtoLengthEnum::MIN_LENGTH->value,
            minMessage: 'Your company address must be at least {{ limit }} characters long',
        )]
        #[Assert\Regex(
            pattern: '/^[\p{L}\s0-9\.]+$/u',
            message: 'Your company address must contain only letters, numbers and spaces'
        )]
        #[Assert\Type('string')]
        public ?string $address,

        #[Assert\NotBlank]
        #[Assert\Length(
            min: CompanyDtoLengthEnum::MIN_LENGTH->value,
            minMessage: 'Your company city must be at least {{ limit }} characters long',
        )]
        #[Assert\Regex(
            pattern: '/^[\p{L}\s\.]+$/u',
            message: 'Your company city must contain only letters and spaces'
        )]
        #[Assert\Type('string')]
        public ?string $city,

        #[Assert\NotBlank]
        #[Assert\Length(
            min: CompanyDtoLengthEnum::POSTAL_CODE_LENGTH->value,
            minMessage: 'Your company postal code must be at least {{ limit }} characters long',
        )]
        #[Assert\Regex(
            pattern: '/^\d{2}-\d{3}$/',
            message: 'Your company postal code must follow the format XX-XXX, where X is a digit.'
        )]
        #[Assert\Type('string')]
        public ?string $postalCode
    ){
    }
}