<?php

declare(strict_types=1);

namespace CompanyInfoApi\Dto;

use CompanyInfoApi\Enum\CompanyDtoLengthEnum;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class EmployeeDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(
            min: CompanyDtoLengthEnum::MIN_LENGTH->value,
            minMessage: 'EmployeeDto name must be at least {{ limit }} characters long',
        )]
        #[Assert\Type('string')]
        public ?string $name,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Length(
            min: CompanyDtoLengthEnum::MIN_LENGTH->value,
            minMessage: 'EmployeeDto last name must be at least {{ limit }} characters long',
        )]
        public ?string $lastName,

        #[Assert\NotBlank]
        #[Assert\Email]
        public ?string $email,

        #[Assert\Length(
            min: CompanyDtoLengthEnum::PHONE_MIN_LENGTH->value,
            max: CompanyDtoLengthEnum::PHONE_MAX_LENGTH->value,
            minMessage: 'EmployeeDto phone number must be at least {{ limit }} characters long',
            maxMessage: 'EmployeeDto phone number must be at most {{ limit }} characters long'
        )]
        #[Assert\Type('string')]
        public ?string $phone,

    ){
    }
}