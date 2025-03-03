<?php

namespace Modules\Iforms\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FieldTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'label',
        'placeholder',
        'description',
    ];

    protected $table = 'iforms__field_translations';
}
