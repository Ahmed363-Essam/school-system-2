<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use Spatie\Translatable\HasTranslations;


class Classroom extends Model
{

    use HasTranslations;

    protected $fillable = ['Name_Class', 'Grade_id'];


    public $translatable = ['Name_Class'];

    protected $table = 'classrooms';
    public $timestamps = true;

    public function Grades()
    {
        return $this->belongsTo('App\Models\grade', 'Grade_id');
    }

}
