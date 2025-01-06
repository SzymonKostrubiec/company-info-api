<?php

declare(strict_types=1);

namespace CompanyInfoApi\Enum;

enum CompanyDtoLengthEnum: int
{
    case MIN_LENGTH = 3;
    case NIP_MIN_LENGTH = 10;
    case NIP_MAX_LENGTH = 11;
    case POSTAL_CODE_LENGTH = 6;
}
