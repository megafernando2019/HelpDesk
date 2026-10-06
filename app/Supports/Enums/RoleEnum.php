<?php

namespace App\Supports\Enums;

enum RoleEnum: int
{
    case SISTEMAS = 1;
    case JEFE_EQUIPO  = 2;
    case USUARIO    = 3;
    case ENCARGADO  = 4;
}