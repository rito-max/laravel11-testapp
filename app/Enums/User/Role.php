<?php

namespace App\Enums\User;

enum Role: int
{
    case Reader = 1;
    case Editor = 2;
}