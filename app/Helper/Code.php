<?php

namespace App\Helper;

use Hackzilla\PasswordGenerator\Generator\RequirementPasswordGenerator;

class Code {

    public static function generateConfirmation(): string
    {
        $generator = new RequirementPasswordGenerator();
        $generator
            ->setLength(8)
            ->setOptionValue(RequirementPasswordGenerator::OPTION_UPPER_CASE, true)
            ->setOptionValue(RequirementPasswordGenerator::OPTION_NUMBERS, true)
            ->setOptionValue(RequirementPasswordGenerator::OPTION_LOWER_CASE, false)
            ->setOptionValue(RequirementPasswordGenerator::OPTION_SYMBOLS, false)
            ->setMinimumCount(RequirementPasswordGenerator::OPTION_UPPER_CASE, 2)
            ->setMinimumCount(RequirementPasswordGenerator::OPTION_NUMBERS, 2);
        return $generator->generatePassword();
    }

    public static function generatePassword(): string
    {
        $generator = new RequirementPasswordGenerator();
        $generator
            ->setLength(12)
            ->setOptionValue(RequirementPasswordGenerator::OPTION_UPPER_CASE, true)
            ->setOptionValue(RequirementPasswordGenerator::OPTION_NUMBERS, true)
            ->setOptionValue(RequirementPasswordGenerator::OPTION_LOWER_CASE, true)
            ->setOptionValue(RequirementPasswordGenerator::OPTION_SYMBOLS, true)
            ->setMinimumCount(RequirementPasswordGenerator::OPTION_UPPER_CASE, 1)
            ->setMinimumCount(RequirementPasswordGenerator::OPTION_NUMBERS, 1)
            ->setMinimumCount(RequirementPasswordGenerator::OPTION_LOWER_CASE, 1)
            ->setMinimumCount(RequirementPasswordGenerator::OPTION_SYMBOLS, 1)
            ->setMaximumCount(RequirementPasswordGenerator::OPTION_SYMBOLS, 3);
        return $generator->generatePassword();
    }
}