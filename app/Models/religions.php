<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\HasTranslations;

class religions extends Model
{
    //
    use HasTranslations;

    public $translatable = ['Name'];

    protected $guarded = [];
}
