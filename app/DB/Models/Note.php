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
        'tab_id',
        'title',
        'content',
        'color',
        'pos_x',
        'pos_y',
        'pos_z',
        'width',
        'height'
    ];

    public function parseToVue(): array
    {
        return [
            'id' => $this->id,
            'tab_id' => $this->tab_id,
            'title' => $this->title,
            'content' => $this->content,
            'color' => $this->color,
            'x' => $this->pos_x,
            'y' => $this->pos_y,
            'zIndex' => $this->pos_z,
            'width' => $this->width,
            'height' => $this->height,
        ];
    }
}
