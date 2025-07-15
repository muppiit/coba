<?php

namespace App\Traits;

use App\Traits\BaseControllerFunction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

trait TraitsController
{
    use BaseControllerFunction, AuthorizesRequests, ValidatesRequests;
}
