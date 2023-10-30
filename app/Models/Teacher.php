<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Teacher extends Authenticatable
{
    //
    use HasTranslations;
    public $translatable = ['Name'];
    protected $guarded=[];


    public function genders()
    {
        return $this->belongsTo('App\Models\Gender','Gender_id');
    }


    public function specializations()
    {
        return $this->belongsTo('App\Models\Specialization','Specialization_id');
    }
    public function Sections()
    {
        return $this->belongsToMany('App\Models\sectoins','teacher_section');
    }
}
