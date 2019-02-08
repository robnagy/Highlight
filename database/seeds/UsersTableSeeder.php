<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User([
            'name' => 'Robert Nagy',
            'email' => 'robert.nagy83@gmail.com',
            'password' => Crypt::encrypt('password'),
        ]);
    }
}
