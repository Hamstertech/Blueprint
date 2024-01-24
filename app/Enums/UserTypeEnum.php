<?php

namespace App\Enums;

enum UserTypeEnum: string
{
    case Customer = 'customer';
    case Admin = 'admin';
    case SuperAdmin = 'super_admin';
}
