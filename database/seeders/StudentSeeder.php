<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
   public function run(): void
   {
       Student::create([
           'name' => 'Andi',
           'class' => 'XI RPL',
       ]);

       Student::create([
           'name' => 'Budi',
           'class' => 'XI RPL',
       ]);

       Student::create([
           'name' => 'Siti',
           'class' => 'XI TKJ',
       ]);

       Student::create([
           'name' => 'Rina',
           'class' => 'XII RPL',
       ]);
   }
}
