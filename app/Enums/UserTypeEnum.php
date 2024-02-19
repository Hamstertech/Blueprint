<?php

namespace App\Enums;

enum UserTypeEnum: string
{
    case Admin = 'admin';
    case Guest = 'guest';
}
