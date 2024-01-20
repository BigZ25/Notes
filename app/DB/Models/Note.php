<?php

namespace App\DB\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Note extends Model
{
    use SoftDeletes, Userstamps;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'color',
        'pos_x',
        'pos_y',
        'pos_z',
        'width',
        'height'
    ];
}
