<?php

namespace App\DB\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Tab extends Model
{
    use SoftDeletes, Userstamps;

    protected $fillable = [
        'user_id',
        'name',
    ];
}
