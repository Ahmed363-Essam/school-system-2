<?php

use Illuminate\Database\Seeder;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $user = new User();

        $user->name = "ahmed essam";
        $user->email = "ahmedessame26@gmail.com";
        $user->password = Hash::make('123456789');

        $user->save();
    }
}
