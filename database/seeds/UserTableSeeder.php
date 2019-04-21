<?php

use Illuminate\Database\Seeder;
use App\Models\User;

use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {

      User::create([
        'name' => 'admin',
        'email' => 'admin@admin.com',
        'password' => Hash::make('123456'),
        'created_at' => date('Y-m-d'),
        'updated_at' => date('Y-m-d')
      ]);


   }
}
