<?php

use Illuminate\Database\Seeder;

use App\Models\grade;
use Illuminate\Support\Facades\DB;
class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('grades')->delete();
        $grades = [
            ['en'=> 'Primary stage', 'ar'=> 'المرحلة الابتدائية'],
            ['en'=> 'middle School', 'ar'=> 'المرحلة الاعدادية'],
            ['en'=> 'High school', 'ar'=> 'المرحلة الثانوية'],
        ];

        foreach ($grades as $grade) {
            grade::create([
                'Name' => $grade,
                'Notes'=>'notesnotes'
            ]);
        }
    }
}
