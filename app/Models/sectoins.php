<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\HasTranslations;

class sectoins extends Model
{
    //
    use HasTranslations;

    public $translatable = ['Name_Section'];

    protected $fillable=['Name_Section','Grade_id','Class_id'];


    public $timestamps = true;


    public function sections()
    {
        return $this->belongsTo('App\Models\Classroom','Class_id');
    }

    public function teachers()
    {
        return $this->belongsToMany('App\Models\Teacher','teacher_section');
    }

    public function Grades()
    {
        return $this->belongsTo('App\Models\grade','Grade_id');
    }
}
