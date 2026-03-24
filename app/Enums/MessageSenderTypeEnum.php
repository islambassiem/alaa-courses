<?php

namespace App\Enums;

enum MessageSenderTypeEnum: string
{
    case USER = 'user';

    case ADMIN = 'admin';
}
