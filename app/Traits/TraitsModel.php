<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

trait TraitsModel
{
    use BaseModelFunction, HasFactory, SoftDeletes;
}
