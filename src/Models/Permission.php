<?php

namespace LaravelGreatApi\Access\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $guarded = ['id'];

    protected $hidden = ['pivot'];
}
