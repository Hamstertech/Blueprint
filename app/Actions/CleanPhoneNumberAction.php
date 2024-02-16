<?php

namespace App\Actions;

use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class CleanPhoneNumberAction
{
    public function execute(string $number): string
    {
        $phoneUtil = PhoneNumberUtil::getInstance();
        $proto = $phoneUtil->parse($number, 'GB');
        $phone_number = $phoneUtil->format($proto, PhoneNumberFormat::E164);

        return $phone_number;
    }
}
