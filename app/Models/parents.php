<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Foundation\Auth\User as Authenticatable;

class parents extends Authenticatable
{
    //

    protected $guarded = [];

    use HasTranslations;

    public $translatable = ['Job_Mother','Name_Mother','Job_Father','Name_Father'];

    public function students()
    {
        return $this->hasMany('App\Models\Students','parent_id');
    }

}
