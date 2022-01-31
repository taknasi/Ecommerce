<?php

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::UpdateOrCreate([
            'name'=>'Ayoub',
            'email' =>'tikna@a.a',
            'password' => bcrypt('123456789')
        ]);
    }
}
