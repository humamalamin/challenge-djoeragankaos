<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Administrator';
        $user->email= 'admin@gmail.com';
        $user->password= bcrypt('secret');
        $user->tipe = 1;

        $user->save();

        $user = new User();
        $user->name = 'member';
        $user->email= 'member@gmail.com';
        $user->password= bcrypt('12345678');
        $user->tipe = 2;

        $user->save();
    }
}
