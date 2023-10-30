<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\HasTranslations;

class grade extends Model
{
    //

    use HasTranslations;

    protected $fillable = ['Name', 'Notes'];


    public $translatable = ['Name'];


    public function sections()
    {
        return $this->hasMany('App\Models\sectoins', 'Grade_id');
    }
}
