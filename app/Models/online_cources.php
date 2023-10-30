<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\User;


class online_cources extends Model
{
    //
    protected $guarded=[];


    public function grade()
    {
        return $this->belongsTo('App\Models\grade', 'Grade_id');
    }


    public function classroom()
    {
        return $this->belongsTo('App\Models\Classroom', 'Classroom_id');
    }


    public function section()
    {
        return $this->belongsTo('App\Models\sectoins', 'section_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
