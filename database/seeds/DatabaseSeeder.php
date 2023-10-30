<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BloodTableSeeder::class);
        $this->call(NationalityTableSeeder::class);
        $this->call(religionTableSeeder::class);
        $this->call(GradeSeeder::class);
        $this->call(GradeTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(UserSeeder::class);

    }
}
