<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\User;

class TestMail2 extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     public $grade;


    public function __construct($grade)
    {
        //

        $this->grade = $grade;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('ae676430@gmail.com','aaaa')->markdown('welcomeEmail')->with([
            'grade'=>$this->grade
        ]);



    }
}
