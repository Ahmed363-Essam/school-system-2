<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use Spatie\Translatable\HasTranslations;

class fees extends Model
{
    //
    use HasTranslations;
    public $translatable = ['title'];
    protected $guarded=[''];


        // علاقة بين الرسوم الدراسية والمراحل الدراسية لجب اسم المرحلة

        public function grade()
        {
            return $this->belongsTo('App\Models\grade', 'Grade_id');
        }
    
    
        // علاقة بين الصفوف الدراسية والرسوم الدراسية لجب اسم الصف
    
        public function classroom()
        {
            return $this->belongsTo('App\Models\Classroom', 'Classroom_id');
        }
}
