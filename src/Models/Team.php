<?php

namespace LaravelGreatApi\Access\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelGreatApi\Access\Traits\HasPermissions;

class Team extends Model
{
    use HasPermissions;

    protected $guarded = ['id'];
}
